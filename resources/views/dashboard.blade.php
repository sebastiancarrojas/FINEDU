<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finedu</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

    @include('components.navbar')

    <section class="dashboard">
        <div class="dashboard-header">
            <h1>Bienvenido, <span>{{ auth()->user()->name }}</span></h1>
            <p>¿Qué quieres hacer hoy?</p>
        </div>
        <div class="dashboard-grid">

            <a href="{{ route('salario') }}" class="servicio-card">
                <div class="servicio-icono">💵</div>
                <h3>Calculadora de Salario</h3>
                <p>Calcula tu salario neto después de descuentos de salud y pensión.</p>
                <span class="servicio-btn">Ir al módulo →</span>
            </a>

            <a href="{{ route('ahorro') }}" class="servicio-card">
                <div class="servicio-icono">🎯</div>
                <h3>Plan de Ahorro</h3>
                <p>Define una meta y descubre cuánto debes ahorrar cada mes para lograrlo.</p>
                <span class="servicio-btn">Ir al módulo →</span>
            </a>

            <a href="{{ route('gastos') }}" class="servicio-card">
                <div class="servicio-icono">📊</div>
                <h3>Planifica tus Gastos</h3>
                <p>Distribuye tu salario de forma saludable y mantén el control de tus finanzas.</p>
                <span class="servicio-btn">Ir al módulo →</span>
            </a>

        </div>
    </section>

</body>
</html>