<?php

namespace App\Http\Controllers;

use App\Models\CafeRestoReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CafeRestoController extends Controller
{
    /**
     * =====================================================
     * SECTION 1: PUBLIC FORM METHODS (YANG SUDAH ADA)
     * =====================================================
     */

    /**
     * Menampilkan form reservasi untuk customer
     */
    public function index()
    {
        return view('caferesto.index');
    }

    /**
     * Menyimpan reservasi baru dari form customer
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // START: Logging untuk debugging
        Log::info('🚀 ========== CAFE RESTO RESERVATION REQUEST ==========');
        Log::info('📋 Request Method: ' . $request->method());
        Log::info('📦 Content Type: ' . $request->header('Content-Type'));
        Log::info('📥 All Request Data:', $request->all());
        Log::info('🔐 CSRF Token: ' . ($request->input('_token') ? 'exists' : 'missing'));
        Log::info('🔄 Is Ajax: ' . ($request->ajax() ? 'yes' : 'no'));
        Log::info('📝 Raw Content:', [$request->getContent()]);
        // END: Logging

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:30',
            'table_type' => 'required|string|max:100',
            'special_request' => 'nullable|string|max:500'
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'date.required' => 'Tanggal reservasi wajib dipilih.',
            'date.after_or_equal' => 'Tanggal reservasi tidak boleh hari kemarin.',
            'time.required' => 'Waktu reservasi wajib dipilih.',
            'guests.required' => 'Jumlah tamu wajib dipilih.',
            'guests.min' => 'Minimum 1 tamu.',
            'guests.max' => 'Maksimum 30 tamu.',
            'table_type.required' => 'Tipe meja wajib dipilih.',
        ]);

        if ($validator->fails()) {
            Log::error('❌ Validation Failed:', $validator->errors()->toArray());

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa data Anda.',
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info('✅ Validation passed');

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Format phone number
            $phone = $request->phone;
            // Hapus semua karakter non-numeric
            $phone = preg_replace('/\D/', '', $phone);
            // Jika dimulai dengan 0, ganti dengan 62
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }
            // Pastikan dimulai dengan 62
            if (substr($phone, 0, 2) !== '62') {
                $phone = '62' . $phone;
            }

            // Generate reservation code
            $lastReservation = CafeRestoReservation::orderBy('id', 'desc')->first();
            $nextNumber = $lastReservation ? (int)substr($lastReservation->reservation_code, -4) + 1 : 1;
            $reservationCode = 'CR' . date('Ymd') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Simpan data ke database
            $reservation = CafeRestoReservation::create([
                'reservation_code' => $reservationCode,
                'name' => $request->name,
                'phone' => $phone,
                'email' => $request->email,
                'date' => $request->date,
                'time' => $request->time,
                'guests' => (int) $request->guests,
                'table_type' => $request->table_type,
                'special_request' => $request->special_request,
                'status' => 'pending'
            ]);

            Log::info('💾 Database save successful');
            Log::info('📊 Reservation Data:', $reservation->toArray());

            // Commit transaksi
            DB::commit();

            // Kirim ke Google Sheets (opsional - jika tidak ada package, lewati)
            try {
                $this->saveToGoogleSheets($reservation);
            } catch (\Exception $e) {
                Log::warning('⚠️ Google Sheets save failed: ' . $e->getMessage());
                // Jangan gagalkan seluruh proses karena Google Sheets error
            }

            // Kirim notifikasi WhatsApp
            $whatsappUrl = $this->sendWhatsAppNotifications($reservation);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat! ID: ' . $reservation->reservation_code,
                'whatsapp_url' => $whatsappUrl,
                'reservation_id' => $reservation->reservation_code,
                'data' => [
                    'name' => $reservation->name,
                    'date' => Carbon::parse($reservation->date)->format('d F Y'),
                    'time' => $reservation->time,
                    'guests' => $reservation->guests,
                    'table_type' => $reservation->table_type
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('💥 Database Save Error: ' . $e->getMessage());
            Log::error('📁 File: ' . $e->getFile());
            Log::error('📍 Line: ' . $e->getLine());
            Log::error('🔍 Trace: ', $e->getTrace());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server. Silakan coba lagi atau hubungi kami langsung.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * =====================================================
     * SECTION 2: ADMIN DASHBOARD METHODS (METHOD BARU)
     * =====================================================
     */

    /**
     * Menampilkan halaman dashboard admin
     */
    public function adminDashboard()
    {
        return view('caferesto.dashboard');
    }

    /**
     * Get statistics for admin dashboard
     */
    public function getDashboardStats()
    {
        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $stats = [
            'total' => CafeRestoReservation::count(),
            'pending' => CafeRestoReservation::where('status', 'pending')->count(),
            'confirmed' => CafeRestoReservation::where('status', 'confirmed')->count(),
            'cancelled' => CafeRestoReservation::where('status', 'cancelled')->count(),
            'today' => CafeRestoReservation::whereDate('date', $today)->count(),
            'this_week' => CafeRestoReservation::whereBetween('date', [$startOfWeek, $endOfWeek])->count(),
            'this_month' => CafeRestoReservation::whereBetween('date', [$startOfMonth, $endOfMonth])->count(),
            'total_guests' => CafeRestoReservation::sum('guests'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get chart data for admin dashboard
     */
    public function getDashboardChartData()
    {
        // Daily reservations for the last 7 days
        $dailyReservations = CafeRestoReservation::select(
            DB::raw('DATE(date) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
            DB::raw('SUM(CASE WHEN status = "confirmed" THEN 1 ELSE 0 END) as confirmed'),
            DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled')
        )
        ->whereBetween('date', [now()->subDays(6)->toDateString(), now()->toDateString()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        // Table type distribution
        $tableDistribution = CafeRestoReservation::select(
            'table_type',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('table_type')
        ->get();

        // Peak hours
        $peakHours = CafeRestoReservation::select(
            DB::raw('HOUR(time) as hour'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('hour')
        ->orderBy('hour', 'ASC')
        ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'daily' => $dailyReservations,
                'table_distribution' => $tableDistribution,
                'peak_hours' => $peakHours
            ]
        ]);
    }

    /**
     * Get recent reservations for admin dashboard
     */
    public function getRecentReservations()
    {
        $recent = CafeRestoReservation::select(
            'reservation_code',
            'name',
            'date',
            'time',
            'guests',
            'table_type',
            'status'
        )
        ->orderBy('created_at', 'DESC')
        ->limit(10)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $recent
        ]);
    }

    /**
     * Get upcoming reservations for admin dashboard
     */
    public function getUpcomingReservations()
    {
        $today = now()->toDateString();
        
        $upcoming = CafeRestoReservation::where('date', '>=', $today)
            ->where('status', 'confirmed')
            ->orderBy('date', 'ASC')
            ->orderBy('time', 'ASC')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $upcoming
        ]);
    }

    /**
     * Get top customers for admin dashboard
     */
    public function getTopCustomers()
    {
        $topCustomers = CafeRestoReservation::select(
            'name',
            'email',
            DB::raw('COUNT(*) as total_reservations'),
            DB::raw('SUM(guests) as total_guests')
        )
        ->groupBy('name', 'email')
        ->orderBy('total_reservations', 'DESC')
        ->limit(5)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $topCustomers
        ]);
    }

    /**
     * =====================================================
     * SECTION 3: ADMIN MANAGEMENT METHODS
     * =====================================================
     */

    /**
     * Menampilkan halaman manajemen reservasi untuk admin
     */
    public function adminIndex()
    {
        return view('caferesto.admin.index');
    }

    /**
     * Get all reservations data for admin table
     */
    public function getReservations(Request $request)
    {
        $query = CafeRestoReservation::query();

        // Apply filters
        if (!empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('reservation_code', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if (!empty($request->status) && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if (!empty($request->table_type) && $request->table_type !== 'all') {
            $query->where('table_type', $request->table_type);
        }

        if (!empty($request->start_date)) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if (!empty($request->end_date)) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Default order by date and time
        $query->orderBy('date', 'desc')
              ->orderBy('time', 'desc');

        // Pagination
        $perPage = $request->per_page ?? 10;
        $reservations = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $reservations->items(),
            'current_page' => $reservations->currentPage(),
            'last_page' => $reservations->lastPage(),
            'total' => $reservations->total(),
            'per_page' => $reservations->perPage()
        ]);
    }

    /**
     * Update reservation status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        try {
            $reservation = CafeRestoReservation::findOrFail($id);
            $oldStatus = $reservation->status;
            $reservation->status = $request->status;
            $reservation->save();

            Log::info('📊 Reservation status updated', [
                'id' => $id,
                'code' => $reservation->reservation_code,
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status reservasi berhasil diperbarui',
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Update status error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete reservation
     */
    public function destroy($id)
    {
        try {
            $reservation = CafeRestoReservation::findOrFail($id);
            $code = $reservation->reservation_code;
            $reservation->delete();

            Log::info('🗑️ Reservation deleted', [
                'id' => $id,
                'code' => $code
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Delete error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus reservasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export reservations to Excel (simulasi)
     */
    public function export(Request $request)
    {
        try {
            $query = CafeRestoReservation::query();

            // Apply filters
            if (!empty($request->start_date)) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if (!empty($request->end_date)) {
                $query->whereDate('date', '<=', $request->end_date);
            }
            if (!empty($request->status) && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $query->orderBy('date', 'desc')->orderBy('time', 'desc');
            
            $reservations = $query->get();

            Log::info('📊 Export data', [
                'total' => $reservations->count(),
                'filters' => $request->all()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Export berhasil',
                'total' => $reservations->count(),
                'data' => $reservations
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Export error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * =====================================================
     * SECTION 4: PRIVATE HELPER METHODS
     * =====================================================
     */

    /**
     * Simpan ke Google Sheets (opsional)
     */
    private function saveToGoogleSheets($reservation)
    {
        try {
            // Cek apakah Google Sheets sudah dikonfigurasi
            if (!env('GOOGLE_SHEETS_ENABLED', false)) {
                Log::info('📊 Google Sheets disabled in .env');
                return;
            }

            $spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');

            if (!$spreadsheetId) {
                Log::warning('📊 Google Sheets: No spreadsheet ID configured');
                return;
            }

            // Data untuk disimpan
            $data = [
                [
                    now()->format('Y-m-d H:i:s'),
                    $reservation->reservation_code,
                    $reservation->name,
                    $reservation->phone,
                    $reservation->email,
                    $reservation->date,
                    $reservation->time,
                    $reservation->guests,
                    $reservation->table_type,
                    $reservation->special_request ?: '-',
                    $reservation->status,
                    $reservation->created_at->format('Y-m-d H:i:s')
                ]
            ];

            Log::info('📊 Google Sheets data prepared:', $data[0]);

            // Gunakan package yang sesuai dengan instalasi Anda
            if (class_exists('Revolution\Google\Sheets\Facades\Sheets')) {
                \Revolution\Google\Sheets\Facades\Sheets::spreadsheet($spreadsheetId)
                    ->sheet('Cafe Reservations')
                    ->append($data);

                Log::info('✅ Google Sheets: Data saved successfully');
            } else {
                Log::info('⚠️ Google Sheets package not installed');
            }
        } catch (\Exception $e) {
            Log::error('❌ Google Sheets Error: ' . $e->getMessage());
            // Jangan throw error agar tidak mengganggu proses utama
        }
    }

    /**
     * Kirim notifikasi WhatsApp ke admin dan customer
     */
    private function sendWhatsAppNotifications($reservation)
    {
        try {
            // Format tanggal Indonesia
            $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            $date = Carbon::parse($reservation->date);
            $hariNama = $hari[$date->dayOfWeek];
            $bulanNama = $bulan[$date->month - 1];
            $tanggalFormat = $hariNama . ', ' . $date->day . ' ' . $bulanNama . ' ' . $date->year;

            // 1. PESAN UNTUK CUSTOMER
            $customerMessage = "Halo *" . $reservation->name . "*!%0A%0A" .
                "*✅ RESERVASI ANDA BERHASIL DIBUAT*%0A" .
                "Legareca Cafe & Resto%0A%0A" .
                "*📋 DETAIL RESERVASI:*%0A" .
                "• ID: *" . $reservation->reservation_code . "*%0A" .
                "• Tanggal: " . $tanggalFormat . "%0A" .
                "• Waktu: " . $reservation->time . " WIB%0A" .
                "• Jumlah Tamu: " . $reservation->guests . " orang%0A" .
                "• Tipe Meja: " . ucfirst($reservation->table_type) . "%0A" .
                "• Status: *MENUNGGU KONFIRMASI*%0A%0A" .
                "*📌 PERMINTAAN KHUSUS:*%0A" .
                ($reservation->special_request ? $reservation->special_request : "Tidak ada") . "%0A%0A" .
                "*📍 LOKASI:*%0A" .
                "Legareca Cafe & Resto%0A" .
                "Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kasihan, Bantul, Yogyakarta 55181%0A%0A" .
                "*📢 INFORMASI PENTING:*%0A" .
                "1. Mohon konfirmasi kehadiran 1 jam sebelumnya%0A" .
                "2. Meja ditahan 15 menit dari waktu reservasi%0A" .
                "3. Untuk perubahan/pembatalan hubungi kami%0A" .
                "4. Free parking tersedia%0A%0A" .
                "*☎️ KONTAK KAMI:*%0A" .
                "📞 (0274) 567-8901%0A" .
                "📧 cafe@legareca.com%0A%0A" .
                "_Terima kasih atas reservasi Anda!%0ASampai jumpa di Legareca Cafe & Resto!_%0A%0A" .
                "Salam,%0ATim Legareca";

            // URL WhatsApp untuk customer
            $customerWhatsAppUrl = "https://wa.me/" . $reservation->phone . "?text=" . $customerMessage;

            Log::info('📱 WhatsApp URL for customer: ' . $customerWhatsAppUrl);

            // 2. PESAN UNTUK ADMIN
            $this->sendAdminNotification($reservation, $tanggalFormat);

            return $customerWhatsAppUrl;
        } catch (\Exception $e) {
            Log::error('❌ WhatsApp Notification Error: ' . $e->getMessage());
            return "https://wa.me/" . $reservation->phone . "?text=Reservasi%20Anda%20berhasil!%20ID:%20" . $reservation->reservation_code;
        }
    }

    /**
     * Kirim notifikasi ke admin (opsional)
     */
    private function sendAdminNotification($reservation, $tanggalFormat)
    {
        try {
            // Nomor admin - bisa disimpan di .env
            $adminPhone = env('ADMIN_WHATSAPP_NUMBER', '6281328897679');

            if (!$adminPhone) {
                Log::info('📱 No admin phone configured');
                return;
            }

            $adminMessage = "*🚨 RESERVASI BARU - LEGARECA CAFE & RESTO*%0A%0A" .
                "*📋 DETAIL RESERVASI:*%0A" .
                "• ID: *" . $reservation->reservation_code . "*%0A" .
                "• Nama: " . $reservation->name . "%0A" .
                "• Telepon: " . $reservation->phone . "%0A" .
                "• Email: " . $reservation->email . "%0A" .
                "• Tanggal: " . $tanggalFormat . "%0A" .
                "• Waktu: " . $reservation->time . " WIB%0A" .
                "• Tamu: " . $reservation->guests . " orang%0A" .
                "• Meja: " . ucfirst($reservation->table_type) . "%0A" .
                "• Permintaan: " . ($reservation->special_request ?: 'Tidak ada') . "%0A" .
                "• Status: PENDING%0A" .
                "• Waktu Input: " . $reservation->created_at->format('d/m/Y H:i') . "%0A%0A" .
                "_Silakan konfirmasi reservasi ini segera._";

            $adminWhatsAppUrl = "https://wa.me/" . $adminPhone . "?text=" . $adminMessage;

            Log::info('📱 Admin notification URL: ' . $adminWhatsAppUrl);
        } catch (\Exception $e) {
            Log::warning('⚠️ Admin notification failed: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk testing form (opsional)
     */
    public function testForm()
    {
        return view('caferesto.test-form');
    }
}