<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class PengajuanIzinNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $filePath;
    public $fileName;
    public $fileMime;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $filePath = null, $fileName = null, $fileMime = null)
    {
        $this->mailData = $mailData;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->fileMime = $fileMime;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $izin = $this->mailData['izin'];

        $mail = $this->subject("📋 Pengajuan Izin Baru - {$izin->nama} - {$izin->jenis_izin}")
            ->view('emails.pengajuan_izin_admin')
            ->with([
                'izin' => $izin,
                'user' => $this->mailData['user'],
                'approveUrl' => $this->mailData['approveUrl'],
                'rejectUrl' => $this->mailData['rejectUrl'],
                'fileAttached' => $this->mailData['fileAttached'] ?? false,
                'fileName' => $this->mailData['fileName'] ?? null,
            ]);

        // Jika ada file, attach ke email
        if ($this->filePath && $this->fileName) {
            Log::info('📎 [MAILABLE] Attaching file to email', [
                'file_path' => $this->filePath,
                'file_name' => $this->fileName,
                'file_mime' => $this->fileMime
            ]);

            try {
                $mail->attach($this->filePath, [
                    'as' => $this->fileName,
                    'mime' => $this->fileMime ?? 'application/octet-stream',
                ]);

                Log::info('✅ [MAILABLE] File attached successfully');
            } catch (\Exception $e) {
                Log::error('❌ [MAILABLE] Failed to attach file: ' . $e->getMessage());
            }
        }

        return $mail;
    }
}