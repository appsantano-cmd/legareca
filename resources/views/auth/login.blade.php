<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email" required>
    <br>

    <input type="password" name="password" placeholder="Password" required>
    <br>

    <button type="submit">Login</button>

    @error('email')
        <p style="color:red">{{ $message }}</p>
    @enderror

    <p>Belum punya akun? <a href="/register">Register</a></p>

</form>

</body>
</html>
