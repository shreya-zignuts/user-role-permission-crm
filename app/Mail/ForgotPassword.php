<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $resetLink
     * @return void
     */
    public function __construct($user, $resetLink)
    {
        $this->user = $user;
        $this->resetLink = $resetLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com', 'Your Name')
            ->subject('Forgot Password Notification')
            ->view('emails.forgot-password')
            ->with([
                'user' => $this->user,
                'resetLink' => $this->resetLink,
            ]);
    }
}
