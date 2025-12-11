<!DOCTYPE html>
<html>
<head>
    <title>Restablecer contraseña</title>
</head>
<body>

<h1>Restablecer contraseña</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email') }}" required><br><br>

    <label>Nueva contraseña</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirmar contraseña</label><br>
    <input type="password" name="password_confirmation" required><br><br>

    <button type="submit">Restablecer contraseña</button>
</form>

</body>
</html>
