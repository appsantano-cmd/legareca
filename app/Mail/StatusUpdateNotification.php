<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $izin = $this->mailData['izin'];
        
        $statusText = $izin->status == 'Disetujui' ? 'Disetujui' : 'Ditolak';
        
        return $this->subject("📋 Update Status Pengajuan Izin - {$statusText}")
                    ->view('emails.pengajuan_izin_user')
                    ->with([
                        'izin' => $izin,
                        'oldStatus' => $this->mailData['oldStatus'],
                    ]);
    }
}