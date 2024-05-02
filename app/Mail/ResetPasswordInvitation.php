<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $adminEmail;

    public $password;

    /**
     * Create a new message instance.
     *
     * @param  string  $adminEmail
     * @param  string  $password
     * @return void
     */
    public function __construct(User $user, $adminEmail, $password)
    {
        $this->user = $user;
        $this->adminEmail = $adminEmail;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->adminEmail)
            ->subject('Reset Password Invitation')
            ->view('emails.reset_password_invitation')
            ->with([
                'user' => $this->user,
                'password' => $this->password,
            ]);
    }
}
