<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1> {{$mailData['user']->name}}</h1>
    <p>Click below to change your password</p>
    <a href="{{ route('resetpassword', ['token' => $mailData['token']]) }}">Click Here</a>
</body>
</html>
