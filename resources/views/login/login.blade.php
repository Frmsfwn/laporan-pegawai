<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>
</head>
<body>
    <form action="" method="POST">
        @csrf
        <a>Username</a><br>
        <input type="text" value="" name="username" maxlength="15" @required(true)><br>
        <a>Password</a><br>
        <input type="password" value="" name="password" maxlength="50" @required(true)><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>