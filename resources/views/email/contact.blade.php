<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Message</title>
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
        }

        .header {
            background-color: #535224;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }

        .content {
            margin: 20px 0;
        }

        .content p {
            margin: 10px 0;
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
            <h1>{{ $mailData['mail_subject'] }}</h1>
        </div>
        <div class="content">
            <p><strong>Name:</strong> {{ $mailData['name'] }}</p>
            <p><strong>Email:</strong> {{ $mailData['email'] }}</p>
            <p><strong>Subject:</strong> {{ $mailData['subject'] }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $mailData['message'] }}</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
