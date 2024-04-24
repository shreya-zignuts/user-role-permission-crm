<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Notification</title>
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
            border: 2px solid #000000;
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
            color: #000000;
        }

        .info {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
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

        .login{
          margin-top: 20px;
          text-align: center;
        }
    </style>
</head>

<body class="mt-3 mb-3">
    <div class="container">
        <div class="card email-content">
            <div class="card-body">
                <h3 style="font-size: 28px; margin-bottom: 10px; text-align: center; color: #000000;">Password Reset Notification</h3>
                <hr style="border-top: 2px solid #4c83ee;">
                <h5 class="card-title">Hello <span style="color: #4c83ee;">{{ $user->first_name }} {{ $user->last_name }},</span></h5>
                <p>Your password is changed by admin..</p>
                <h3>Your Login Details :</h3>
                <p class="info"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="info"><strong>New Password:</strong> <span style="color: #4c83ee;">{{ $password }}</span></p>
                <div class="login">
                    <a href="{{ route('login') }}" class="btn">Log In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
