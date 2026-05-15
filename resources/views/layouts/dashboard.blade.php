<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finedu</title>

    <link rel="icon" type="image/png" href="{{ asset('imagenes/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
</head>
<body>

    <x-navbar-dashboard />

    @yield('content')

</body>
</html>