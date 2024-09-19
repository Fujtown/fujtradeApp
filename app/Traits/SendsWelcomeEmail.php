<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendsWelcomeEmail
{
    public function sendWelcomeEmail($to, $link, $email, $password)
    {

$subject = 'Welcome to Futrade!';

// Prepare your HTML message
$message = '
<html>
<head>
    <style>
        body {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #eee;
            padding: 20px;
        }
        h1 {
            color: #4A90E2;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome!</h1>
        <p>You have been successfully registered on Futrade.</p>
        <p>Your login details are as follows:</p>
        <ul>
            <li>Login Here: <strong><a href="'.$link.'">Login Now</a></strong></li>
            <li>Email: <strong>'.$email.'</strong></li>
            <li>Password: <strong>'.$password.'</strong></li>
        </ul>
        <p>Please change your password after your first login for security reasons.</p>
        <div class="footer">
            &copy; '.date("Y").' Futrade. All rights reserved.
        </div>
    </div>
</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: info@fujtrade.com' . "\r\n" .
    'Reply-To: info@fujtrade.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    }
}
