<p>Dear User,</p>
<p>You have been invited to reset your password. Please click the following link to reset your password:</p>
<a href="{{ route('password.reset', ['token' => $user->invitation_token]) }}">Reset Password</a>
