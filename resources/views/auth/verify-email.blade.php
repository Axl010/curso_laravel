<!DOCTYPE html>
<html>
<head>
    <title>Verificar email</title>
</head>
<body>

<h1>Verifica tu correo</h1>

<p>Te hemos enviado un enlace de verificación a tu email.</p>

@if (session('status') == 'verification-link-sent')
    <p style="color:green;">Se ha enviado un nuevo enlace.</p>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Reenviar enlace</button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>

</body>
</html>
