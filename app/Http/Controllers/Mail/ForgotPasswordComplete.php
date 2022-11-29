<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordComplete extends Mailable
{
    use Queueable;
    use SerializesModels;
    protected $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->subject('パスワード変更完了')
            ->view('mail.forgotPasswordComplete')
            ->with([
                'data' => $this->mailData,
            ]);
    }
}
