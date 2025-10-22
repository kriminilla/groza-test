<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        $url = url('/admin/reset-password/' . $this->token);

        return $this->subject('Reset Password Admin GROZA')
                    ->view('admin.auth.confirmation')
                    ->with(['url' => $url]);
    }
}
