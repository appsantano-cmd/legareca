<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TukarShiftStatusUpdateNotification extends Mailable
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
        $shifting = $this->mailData['shifting'];
        
        $statusText = $shifting->status == 'disetujui' ? 'Disetujui' : 'Ditolak';
        
        return $this->subject("🔄 Update Status Pengajuan Tukar Shift - {$statusText}")
                    ->view('emails.tukar_shift_user')
                    ->with([
                        'shifting' => $shifting,
                        'oldStatus' => $this->mailData['oldStatus'],
                    ]);
    }
}