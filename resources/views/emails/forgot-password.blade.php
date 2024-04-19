<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Invitation</title>
    <style>
        /* Your email styling goes here */
    </style>
</head>

<body>
    <div>
        <h1>Password Reset Mail</h1>
        <p>You have been invited to reset your password.</p>
        <p>Please click the following link to reset your password:</p>
        <a href="{{ route('reset.password.form', ['email' => $user->email]) }}" class="btn">Reset Password</a>
        <p>If you did not request a password reset, please ignore this email.</p>
    </div>
</body>

</html>
