<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
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
            <li>Login Here: <strong><a href="{{$link}}">Login Now</a></strong></li>
            <li>Email: <strong>{{ $email }}</strong></li>
            <li>Password: <strong>{{ $password }}</strong></li>
        </ul>
        <p>Please change your password after your first login for security reasons.</p>
        <div class="footer">
            &copy; {{ date('Y') }} Futrade. All rights reserved.
        </div>

</div>
</body>
</html>
