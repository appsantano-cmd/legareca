<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TukarShiftNotification extends Mailable
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
        
        return $this->subject("🔄 Pengajuan Tukar Shift Baru - {$shifting->nama_karyawan}")
                    ->view('emails.tukar_shift_admin')
                    ->with([
                        'shifting' => $shifting,
                        'user' => $this->mailData['user'],
                        'approveUrl' => $this->mailData['approveUrl'],
                        'rejectUrl' => $this->mailData['rejectUrl'],
                    ]);
    }
}