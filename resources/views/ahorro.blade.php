@extends('layouts.app')

@section('content')

<main class="ahorro-main">

    <div class="ahorro-header">
        <div class="ahorro-header-texto">
            <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
            <h1>Plan de <span>Ahorro</span></h1>
            <p>Define tu meta, el plazo y descubre cuánto debes ahorrar cada mes.</p>
        </div>
    </div>

    <div class="ahorro-contenedor">

        <!-- COLUMNA IZQUIERDA: Formulario -->
        <aside class="ahorro-sidebar">
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">🎯</span>
                    <h2>Define tu meta</h2>
                </div>

                @if(session('exito'))
                    <div class="alerta-exito">✓ {{ session('exito') }}</div>
                @endif

                @if($errors->any())
                    <div class="alerta-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('ahorro.store') }}">
                    @csrf

                    <div class="campo">
                        <label for="meta_nombre">Nombre de la meta</label>
                        <input type="text" id="meta_nombre" name="meta_nombre"
                               placeholder="Ej: Viaje a Cartagena"
                               value="{{ old('meta_nombre') }}"
                               style="padding:11px 14px;border:1.5px solid #D1D5DB;border-radius:8px;font-size:0.93rem;font-family:inherit;width:100%;box-sizing:border-box;"
                               required>
                    </div>

                    <div class="campo">
                        <label for="valor_meta">Meta de ahorro</label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">$</span>
                            <input type="number" id="valor_meta" name="valor_meta"
                                   placeholder="0" min="1"
                                   value="{{ old('valor_meta') }}" required>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="ahorro_actual">Ahorro actual</label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">$</span>
                            <input type="number" id="ahorro_actual" name="ahorro_actual"
                                   placeholder="0" min="0"
                                   value="{{ old('ahorro_actual', 0) }}" required>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="plazo_meses">Plazo</label>
                        <div class="select-wrapper">
                            <select id="plazo_meses" name="plazo_meses" required>
                                <option value="" disabled selected>Selecciona el plazo</option>
                                <option value="3">3 meses</option>
                                <option value="6">6 meses</option>
                                <option value="12">1 año</option>
                                <option value="18">1 año y medio</option>
                                <option value="24">2 años</option>
                                <option value="36">3 años</option>
                                <option value="48">4 años</option>
                                <option value="60">5 años</option>
                            </select>
                            <span class="select-arrow">▾</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-calcular">Guardar plan</button>
                </form>
            </div>
        </aside>

        <!-- COLUMNA DERECHA: Planes guardados -->
        <section class="ahorro-resultados-seccion">

            @forelse($planes as $plan)
                @php
                    $porcentaje = $plan->valor_meta > 0
                        ? min(100, round(($plan->ahorro_actual / $plan->valor_meta) * 100))
                        : 0;
                    $falta = max(0, $plan->valor_meta - $plan->ahorro_actual);
                @endphp

                <div class="card">
                    <div class="card-titulo" style="justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span class="card-icono">🎯</span>
                            <h2>{{ $plan->meta_nombre }}</h2>
                        </div>
                        <form method="POST" action="{{ route('ahorro.destroy', $plan->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background:none;border:none;cursor:pointer;color:#FCA5A5;font-size:1.2rem;"
                                    title="Eliminar plan">🗑</button>
                        </form>
                    </div>

                    <!-- Barra de progreso -->
                    <div class="progreso-labels">
                        <span>Ahorrado: <strong>${{ number_format($plan->ahorro_actual, 0, ',', '.') }}</strong></span>
                        <span>Meta: <strong>${{ number_format($plan->valor_meta, 0, ',', '.') }}</strong></span>
                    </div>
                    <div class="barra-fondo">
                        <div class="barra-progreso" style="width: {{ $porcentaje }}%"></div>
                    </div>
                    <div class="progreso-porcentaje">
                        <span>{{ $porcentaje }}%</span> completado
                    </div>

                    <!-- Desglose -->
                    <div class="resultado-lista" style="margin-top:20px;">
                        <div class="resultado-fila">
                            <span>⏳ Plazo</span>
                            <strong>{{ $plan->plazo_meses }} meses</strong>
                        </div>
                        <div class="resultado-fila">
                            <span>💸 Falta por ahorrar</span>
                            <strong>${{ number_format($falta, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <!-- Cuota mensual -->
                    <div style="background:#1F2937;border-radius:10px;padding:16px;text-align:center;margin-top:16px;">
                        <p style="color:#9CA3AF;font-size:0.85rem;margin-bottom:6px;">Debes ahorrar cada mes</p>
                        <span style="font-size:2rem;font-weight:800;color:#FBBF24;">
                            ${{ number_format($plan->ahorro_mensual, 0, ',', '.') }}
                        </span>
                        <p style="color:#9CA3AF;font-size:0.85rem;margin-top:6px;">
                            durante <strong style="color:#FEFCE8;">{{ $plan->plazo_meses }} meses</strong>
                        </p>
                    </div>
                </div>

            @empty
                <div class="card" style="text-align:center;padding:60px 28px;">
                    <div style="font-size:3rem;margin-bottom:16px;">🎯</div>
                    <h3 style="color:#1F2937;margin-bottom:8px;">Aún no tienes planes de ahorro</h3>
                    <p style="color:#6B7280;font-size:0.9rem;">Crea tu primera meta usando el formulario.</p>
                </div>
            @endforelse

        </section>
    </div>
</main>

<link rel="stylesheet" href="{{ asset('css/ahorro.css') }}">

<style>
.alerta-exito {
    background: rgba(34,197,94,0.15);
    border: 1px solid rgba(34,197,94,0.4);
    color: #166534;
    border-radius: 7px;
    padding: 10px 14px;
    font-size: 0.85rem;
    margin-bottom: 16px;
}
.alerta-error {
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.3);
    color: #991B1B;
    border-radius: 7px;
    padding: 10px 14px;
    font-size: 0.85rem;
    margin-bottom: 16px;
}
</style>

@endsection