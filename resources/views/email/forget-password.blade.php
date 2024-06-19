<!-- resources/views/emails/forget-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            margin: 20px 0;
            color: #555555;
        }

        .content p {
            margin: 10px 0;
        }

        .content a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #afc4db;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            color: #000000
        }

        .content a:hover {
            background-color: #ffffff;
            color: #3d3939
        }

        .footer {
            text-align: center;
            color: #888888;
            font-size: 12px;
            margin-top: 20px;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Dear {{ $mailData['user']->name }},</p>
            <p>We received a request to reset your password. Click the button below to reset it:</p>
            <a href="{{ route('front.resetPassword', $mailData['token']) }}">Reset Password</a>
            <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
            <p>Thank you,</p>
            <p>Laravel Online Shope</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
