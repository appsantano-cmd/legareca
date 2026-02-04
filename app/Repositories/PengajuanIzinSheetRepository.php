<?php

namespace App\Repositories;

use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Log;

class PengajuanIzinSheetRepository
{
    protected GoogleSheetsService $service;
    protected string $spreadsheetId;
    protected string $sheetName = 'Pengajuan Izin';
    
    public function __construct()
    {
        $this->service = new GoogleSheetsService();
        $this->spreadsheetId = '1ENclJ4VKSh4zsz5WAD5dAsQZg654FtUDJLyQnH3p9NI';
    }
    
    /**
     * Append single data to Google Sheets (FIXED VERSION)
     */
    public function appendSingle($item): bool
    {
        try {
            Log::info('🚀 Starting Google Sheets append for izin ID: ' . $item->id);
            
            // Prepare data in CORRECT array format
            $rowData = [
                (int) $item->id,
                (string) $item->nama,
                (string) $item->divisi,
                (string) $item->jenis_izin,
                $item->tanggal_mulai instanceof \Carbon\Carbon ? 
                    $item->tanggal_mulai->format('d-m-Y') : 
                    (string) $item->tanggal_mulai,
                $item->tanggal_selesai instanceof \Carbon\Carbon ? 
                    $item->tanggal_selesai->format('d-m-Y') : 
                    (string) $item->tanggal_selesai,
                (int) $item->jumlah_hari,
                (string) ($item->keterangan_tambahan ?? ''),
                (string) $item->nomor_telepon,
                (string) $item->alamat,
                (string) ($item->documen_pendukung ?? ''),
                (string) ($item->user_email ?? ''),
                (string) $item->status,
                (string) ($item->catatan_admin ?? ''),
                (string) ($item->disetujui_oleh ?? ''),
                $item->tanggal_persetujuan ? 
                    ($item->tanggal_persetujuan instanceof \Carbon\Carbon ? 
                        $item->tanggal_persetujuan->format('d-m-Y H:i:s') : 
                        (string) $item->tanggal_persetujuan) : '',
                $item->created_at ? 
                    ($item->created_at instanceof \Carbon\Carbon ? 
                        $item->created_at->format('d-m-Y H:i:s') : 
                        (string) $item->created_at) : '',
            ];
            
            Log::info('📊 Prepared row data for izin ID ' . $item->id . ':', [
                'id' => $rowData[0],
                'nama' => $rowData[1],
                'divisi' => $rowData[2],
                'email' => $rowData[11], // Perhatikan ini
                'status' => $rowData[12],
            ]);
            
            // Use appendMany instead of append to avoid overwriting
            $this->service->appendMany([$rowData], "{$this->sheetName}!A2");
            
            Log::info('✅ Successfully appended to Google Sheets for izin ID: ' . $item->id);
            return true;
            
        } catch (\Exception $e) {
            Log::error('❌ Error appending to Google Sheets: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Update status in Google Sheets (FIXED VERSION)
     */
    public function updateStatus($id, $status, $catatan_admin = null, $disetujui_oleh = null): bool
    {
        try {
            Log::info('🔄 Updating Google Sheets status for izin ID: ' . $id);
            
            // Find the row first by reading ALL data
            $allData = $this->getAllData();
            
            $rowNumber = null;
            foreach ($allData as $index => $row) {
                if (isset($row['id']) && (int)$row['id'] === (int)$id) {
                    $rowNumber = $index + 2; // +2 because header is row 1 and index starts from 0
                    break;
                }
            }
            
            if (!$rowNumber) {
                Log::warning('❌ Row not found for izin ID: ' . $id);
                return false;
            }
            
            Log::info('📌 Found row number: ' . $rowNumber . ' for izin ID: ' . $id);
            
            // Update the specific cells
            // Column M (13th) = Status, N (14th) = Catatan Admin, O (15th) = Disetujui Oleh, P (16th) = Tanggal Persetujuan
            $updateData = [
                [$status, $catatan_admin ?? '', $disetujui_oleh ?? '', now()->format('Y-m-d H:i:s')]
            ];
            
            $updateRange = "{$this->sheetName}!M{$rowNumber}:P{$rowNumber}";
            
            Log::info('📝 Update data for range ' . $updateRange . ':', $updateData[0]);
            
            // Use update instead of append
            $this->updateRange($updateRange, $updateData);
            
            Log::info('✅ Status updated in Google Sheets for izin ID: ' . $id);
            return true;
            
        } catch (\Exception $e) {
            Log::error('❌ Error updating status in Google Sheets: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update a specific range in Google Sheets
     */
    private function updateRange(string $range, array $data): void
    {
        $service = $this->service->raw();
        
        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $data
        ]);
        
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];
        
        $service->spreadsheets_values->update(
            $this->spreadsheetId,
            $range,
            $body,
            $params
        );
    }
    
    /**
     * Clear and recreate sheet with correct data
     */
    public function recreateSheet(): bool
    {
        try {
            Log::info('🔄 Recreating Google Sheet: ' . $this->sheetName);
            
            // Get all data from database
            $allData = \App\Models\PengajuanIzin::orderBy('id')->get();
            
            if ($allData->isEmpty()) {
                Log::info('No data to recreate');
                return true;
            }
            
            // Prepare all rows
            $rows = [];
            foreach ($allData as $item) {
                $rows[] = [
                    (int) $item->id,
                    (string) $item->nama,
                    (string) $item->divisi,
                    (string) $item->jenis_izin,
                    $item->tanggal_mulai instanceof \Carbon\Carbon ? 
                        $item->tanggal_mulai->format('d-m-Y') : 
                        (string) $item->tanggal_mulai,
                    $item->tanggal_selesai instanceof \Carbon\Carbon ? 
                        $item->tanggal_selesai->format('d-m-Y') : 
                        (string) $item->tanggal_selesai,
                    (int) $item->jumlah_hari,
                    (string) ($item->keterangan_tambahan ?? ''),
                    (string) $item->nomor_telepon,
                    (string) $item->alamat,
                    (string) ($item->documen_pendukung ?? ''),
                    (string) ($item->user_email ?? ''),
                    (string) $item->status,
                    (string) ($item->catatan_admin ?? ''),
                    (string) ($item->disetujui_oleh ?? ''),
                    $item->tanggal_persetujuan ? 
                        ($item->tanggal_persetujuan instanceof \Carbon\Carbon ? 
                            $item->tanggal_persetujuan->format('d-m-Y H:i:s') : 
                            (string) $item->tanggal_persetujuan) : '',
                    $item->created_at ? 
                        ($item->created_at instanceof \Carbon\Carbon ? 
                            $item->created_at->format('d-m-Y H:i:s') : 
                            (string) $item->created_at) : '',
                ];
            }
            
            // Clear existing data (keep header)
            $this->clearData();
            
            // Add header
            $this->ensureHeader();
            
            // Append all data
            if (!empty($rows)) {
                $this->service->appendMany($rows, "{$this->sheetName}!A2");
                Log::info('✅ Recreated sheet with ' . count($rows) . ' rows');
            }
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('❌ Error recreating sheet: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear all data except header
     */
    private function clearData(): void
    {
        try {
            $service = $this->service->raw();
            
            // Clear rows from A2 to Q (all rows except header)
            $body = new \Google\Service\Sheets\ClearValuesRequest();
            
            $service->spreadsheets_values->clear(
                $this->spreadsheetId,
                "{$this->sheetName}!A2:Q",
                $body
            );
            
            Log::info('✅ Cleared existing data from sheet');
            
        } catch (\Exception $e) {
            Log::error('Error clearing data: ' . $e->getMessage());
        }
    }
    
    /**
     * Test connection to Google Sheets
     */
    public function testConnection(): array
    {
        try {
            $values = $this->service->getValues("{$this->sheetName}!A1:Q1");
            
            return [
                'success' => true,
                'message' => 'Connection successful',
                'has_header' => !empty($values),
                'header' => $values[0] ?? null,
                'header_count' => count($values[0] ?? []),
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'sheet_name' => $this->sheetName,
            ];
        }
    }
    
    /**
     * Ensure sheet has correct header
     */
    public function ensureHeader(): bool
    {
        try {
            $headers = [
                'ID',
                'Nama',
                'Divisi',
                'Jenis Izin',
                'Tanggal Mulai',
                'Tanggal Selesai',
                'Jumlah Hari',
                'Keterangan',
                'Nomor Telepon',
                'Alamat',
                'Dokumen Pendukung',
                'Email Karyawan',
                'Status',
                'Catatan Admin',
                'Disetujui Oleh',
                'Tanggal Persetujuan',
                'Created At',
            ];
            
            $this->service->setHeader($headers, "{$this->sheetName}!A1");
            
            Log::info('✅ Header created for sheet: ' . $this->sheetName);
            return true;
            
        } catch (\Exception $e) {
            Log::error('❌ Error creating header: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all data from Google Sheets
     */
    public function getAllData(): array
    {
        try {
            $rows = $this->service->getValues("{$this->sheetName}!A2:Q");
            
            if (empty($rows)) {
                return [];
            }
            
            $data = [];
            foreach ($rows as $row) {
                if (empty($row[0])) continue;
                
                $data[] = [
                    'id' => (int) ($row[0] ?? 0),
                    'nama' => $row[1] ?? '',
                    'divisi' => $row[2] ?? '',
                    'jenis_izin' => $row[3] ?? '',
                    'tanggal_mulai' => $row[4] ?? '',
                    'tanggal_selesai' => $row[5] ?? '',
                    'jumlah_hari' => (int) ($row[6] ?? 0),
                    'keterangan_tambahan' => $row[7] ?? '',
                    'nomor_telepon' => $row[8] ?? '',
                    'alamat' => $row[9] ?? '',
                    'documen_pendukung' => $row[10] ?? '',
                    'user_email' => $row[11] ?? '',
                    'status' => $row[12] ?? 'Pending',
                    'catatan_admin' => $row[13] ?? '',
                    'disetujui_oleh' => $row[14] ?? '',
                    'tanggal_persetujuan' => $row[15] ?? '',
                    'created_at' => $row[16] ?? '',
                ];
            }
            
            return $data;
            
        } catch (\Exception $e) {
            Log::error('Error getting all data: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fix existing data in Google Sheets
     */
    public function fixExistingData(): array
    {
        $report = [
            'fixed' => 0,
            'errors' => []
        ];
        
        try {
            Log::info('🔧 Fixing existing data in Google Sheets');
            
            // Recreate the entire sheet
            if ($this->recreateSheet()) {
                $report['fixed'] = \App\Models\PengajuanIzin::count();
                Log::info('✅ Fixed ' . $report['fixed'] . ' records');
            }
            
        } catch (\Exception $e) {
            $report['errors'][] = $e->getMessage();
            Log::error('❌ Error fixing data: ' . $e->getMessage());
        }
        
        return $report;
    }
}