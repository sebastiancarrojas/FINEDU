@extends('layouts.dashboard')
@section('content')

{{-- ══════════════════════════════════════════
     MÓDULO 1: ENCABEZADO DEL DASHBOARD
     Saluda al usuario autenticado por su nombre
     usando auth()->user()->name que viene de
     la sesión de Laravel automáticamente.
     No requiere controlador propio; usa el
     middleware 'auth' definido en las rutas.
══════════════════════════════════════════ --}}
<section class="dashboard">
    <div class="dashboard-header">
        <h1>Bienvenido, <span>{{ auth()->user()->name }}</span></h1>
        <p>¿Qué quieres hacer hoy?</p>
    </div>

    {{-- ══════════════════════════════════════════
         MÓDULO 2: GRID DE MÓDULOS
         Tarjetas de navegación hacia cada módulo
         de la aplicación. Cada tarjeta es un enlace
         que redirige a su ruta correspondiente.
    ══════════════════════════════════════════ --}}
    <div class="dashboard-grid">

        {{-- ══════════════════════════════════════════
             MÓDULO 2A: TARJETA — CALCULADORA DE SALARIO
             Redirige a la vista de cálculo de salario.
             No usa controlador con BD; toda su lógica
             es client-side (JavaScript + sessionStorage).
        ══════════════════════════════════════════ --}}
        <a href="{{ route('salario') }}" class="servicio-card">
            <div class="servicio-icono">💵</div>
            <h3>Calculadora de Salario</h3>
            <p>Calcula tu salario neto después de descuentos de salud y pensión.</p>
            <span class="servicio-btn">Ir al módulo →</span>
        </a>

        {{-- ══════════════════════════════════════════
             MÓDULO 2B: TARJETA — PLAN DE AHORRO
             Redirige al módulo de planes de ahorro.
             Maneja CRUD completo con BD via
             PlanAhorroController. Usa SESSION y
             COOKIE para recordar acciones del usuario.
        ══════════════════════════════════════════ --}}
        <a href="{{ route('ahorro') }}" class="servicio-card">
            <div class="servicio-icono">🎯</div>
            <h3>Plan de Ahorro</h3>
            <p>Define una meta y descubre cuánto debes ahorrar cada mes para lograrlo.</p>
            <span class="servicio-btn">Ir al módulo →</span>
        </a>

        {{-- ══════════════════════════════════════════
             MÓDULO 2C: TARJETA — PLANIFICADOR DE GASTOS
             Redirige al módulo de gastos mensuales.
             Maneja CRUD completo con BD via
             GastoController. Usa SESSION para recordar
             el último mes consultado y COOKIE para
             pre-seleccionar la categoría favorita.
        ══════════════════════════════════════════ --}}
        <a href="{{ route('gastos') }}" class="servicio-card">
            <div class="servicio-icono">📊</div>
            <h3>Planifica tus Gastos</h3>
            <p>Distribuye tu salario de forma saludable y mantén el control de tus finanzas.</p>
            <span class="servicio-btn">Ir al módulo →</span>
        </a>

    </div>
</section>

{{-- CSS cargado al final para no bloquear el render --}}
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@endsection