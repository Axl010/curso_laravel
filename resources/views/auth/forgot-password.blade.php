<!DOCTYPE html>
<html>
<head>
    <title>Recuperar contraseña</title>
</head>
<body>

<h1>Recuperar contraseña</h1>

@if (session('status'))
    <p style="color:green;">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit">Enviar enlace</button>
</form>

</body>
</html>
