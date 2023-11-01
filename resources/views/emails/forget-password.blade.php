<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; padding: 20px;">
<h1 style="color: #3498db;">Reset Password</h1>
<p style="color: #555; font-size: 16px;">Click the link below to reset your password:</p>
<a href="{{route('admin.resetPassword', $token)}}" style="display: inline-block; background-color: #3498db; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px;">Reset Password</a>
</body>
</html>
