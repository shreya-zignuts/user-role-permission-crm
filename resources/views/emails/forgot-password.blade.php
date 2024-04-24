{{-- <!DOCTYPE html>
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

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Mail</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    <table style="width: 100%; height: 100vh;">
        <tr>
            <td align="center" valign="middle">
                <div style="max-width: 600px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;">
                  <h1 style="font-size: 28px; margin-bottom: 20px; text-align: center;">Password Reset Invitation</h1>
                <hr style="border-top: 2px solid #4c83ee;">
                    <p>You have been invited to reset your password.</p>
                    <p>Please click the following button to reset your password:</p>
                    <a href="{{ route('reset.password.form', ['email' => $user->email]) }}" style="display: inline-block; padding: 10px 20px; margin: 10px 0; text-decoration: none; color: #fff; background-color: #007bff; border-radius: 5px;">Reset Password</a>
                    <p>If you did not request a password reset, please ignore this email.</p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
