<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body style="margin:100px">
    <h1>You have requested to reset your password</h1>
    <hr>
    <h5> Please click the reset link bellow . Your password reset link is:</h5>
    <div>
        <h3>
            <a href="http://127.0.0.1:3000/api/reset/{{$token}}"> reset password</a>
        </h3>
    </div>
</body>
</html>