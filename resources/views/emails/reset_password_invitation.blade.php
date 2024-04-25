<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .email-content {
            width: 90%;
            max-width: 600px;
            border: 2px solid #4c83ee;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .info {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #4c83ee;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #4c83ee;
        }

        .login {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body class="mt-3 mb-3">
    <div class="container">
        <div class="card email-content">
            <div class="card-body">
                <h1 style="font-size: 28px; margin-bottom: 20px; text-align: center;">Password Reset Invitation</h1>
                <hr style="border-top: 2px solid #4c83ee;">
                <p class="card-title">Dear <span style="color: #4c83ee;">{{ $user->first_name }}
                        {{ $user->last_name }},</span></p>
                <p class="info">You have been invited to reset your password. <br></p>
                <p class="info">Please click the following link to reset your password:</p>
                <div class="login">
                    <a href="{{ route('password.reset', ['token' => $user->invitation_token]) }}" class="btn">Reset
                        Password</a>
                </div>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
