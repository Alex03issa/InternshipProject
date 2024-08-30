<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            max-width: 600px;
            margin: 50px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #666666;
            margin-bottom: 30px;
            text-align: center;
        }
        .verify-button {
            display: inline-block;
            background:#252c38;
            border: 1px solid #252c38;
            color: white;
            border-radius: 32px;
            font-size: 16px;
            line-height: 0;
            text-decoration: none;
            transition: all 0.2s;
            padding: 15px 25px;
            text-align: center;
            margin: 0 auto;
            display: block;
            
        }
        .verify-button:hover {
            border: 1px solid #252c38;
            background-color: transparent;
            color: #252c38; 
            text-decoration: none;
        }
        .footer {
            font-size: 12px;
            color: #999999;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="images/logo.svg" alt="Logo"> 
        </div>
        <div class="title">
            Welcome to Side to Side
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Thank you for signing up with Side to Side. Please verify your email address by clicking the button below:</p>
        </div>
        <a href="{{ $verificationUrl }}" class="verify-button">Verify Email</a>
        <div class="footer">
            <p>If you did not sign up for this account, please ignore this email.</p>
            <p>&copy; 2024 Side to Side. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
