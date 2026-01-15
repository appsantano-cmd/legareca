<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;

class NotificationService
{
    public static function send($type, $userId, $data = [])
    {
        $title = '';
        $message = '';
        $senderId = auth()->id();

        switch ($type) {
            case 'cleaning_submitted':
                $title = 'Cleaning Report Submitted';
                $area = $data['area'] ?? $data['departemen'] ?? 'Unknown Area';
                $message = $data['staff_name'] . ' telah mengirim laporan cleaning untuk ' . $area;
                break;
                
            case 'sifting_requested':
                $title = 'Shift Change Request';
                $message = $data['staff_name'] . ' mengajukan penukaran shift';
                break;
                
            case 'izin_submitted':
                $title = 'Leave Request Submitted';
                $message = $data['staff_name'] . ' mengajukan izin cuti';
                break;
                
            case 'user_registered':
                $title = 'New User Registered';
                $message = $data['name'] . ' telah bergabung sebagai ' . $data['role'];
                break;
        }

        // Untuk cleaning, sifting, izin: notifikasi untuk admin/developer DAN staff terkait
        if (in_array($type, ['cleaning_submitted', 'sifting_requested', 'izin_submitted'])) {
            // 1. Kirim ke admin/developer
            $admins = User::whereIn('role', ['admin', 'developer'])->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'sender_id' => $senderId,
                    'type' => $type,
                    'title' => $title,
                    'message' => $message,
                    'data' => $data
                ]);
            }
            
            // 2. Juga kirim ke staff yang bersangkutan (confirmation notification)
            if ($type === 'cleaning_submitted' || $type === 'izin_submitted') {
                // Staff akan mendapat notifikasi bahwa submission mereka berhasil
                $confirmationMessage = '';
                
                if ($type === 'cleaning_submitted') {
                    $confirmationMessage = 'Laporan cleaning Anda telah berhasil dikirim untuk ' . ($data['departemen'] ?? '');
                } elseif ($type === 'izin_submitted') {
                    $confirmationMessage = 'Pengajuan izin Anda telah berhasil dikirim. Menunggu persetujuan.';
                } elseif ($type === 'sifting_requested') {
                    $confirmationMessage = 'Permintaan tukar shift Anda telah berhasil dikirim.';
                }
                
                Notification::create([
                    'user_id' => $userId, // Staff yang submit
                    'sender_id' => $senderId,
                    'type' => $type . '_confirmation',
                    'title' => 'Submission Confirmed',
                    'message' => $confirmationMessage,
                    'data' => $data
                ]);
            }
        } else {
            // Untuk notifikasi lainnya (user_registered, dll)
            Notification::create([
                'user_id' => $userId,
                'sender_id' => $senderId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data
            ]);
        }
    }
}