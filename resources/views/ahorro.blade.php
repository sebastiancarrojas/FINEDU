@extends('layouts.dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('css/ahorro.css') }}">

{{-- ── ESTILOS: alertas de éxito y error del formulario ── --}}
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

<main class="ahorro-main">

    {{-- ══════════════════════════════════════════
         MÓDULO 1: ENCABEZADO DE LA PÁGINA
         Muestra el título principal, subtítulo
         y el botón para volver al dashboard.
    ══════════════════════════════════════════ --}}
    <div class="ahorro-header">
        <div class="ahorro-header-texto">
            <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
            <h1>Plan de <span>Ahorro</span></h1>
            <p>Define tu meta, el plazo y descubre cuánto debes ahorrar cada mes.</p>
        </div>
    </div>

    <div class="ahorro-contenedor">

        {{-- ══════════════════════════════════════════
             MÓDULO 2: FORMULARIO — CREAR NUEVO PLAN
             CRUD: CREATE
             Sidebar izquierdo con el formulario para
             registrar una nueva meta de ahorro.
             Incluye validación de campos y mensajes
             de éxito/error de la sesión flash.
        ══════════════════════════════════════════ --}}
        <aside class="ahorro-sidebar">
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">🎯</span>
                    <h2>Define tu meta</h2>
                </div>

                {{-- Mensaje flash de éxito (store, update, destroy, abonar, retirar) --}}
                @if(session('exito'))
                    <div class="alerta-exito">✓ {{ session('exito') }}</div>
                @endif

                {{-- Errores de validación del formulario --}}
                @if($errors->any())
                    <div class="alerta-error">{{ $errors->first() }}</div>
                @endif

                {{-- Formulario CREATE: envía a PlanAhorroController@store --}}
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

        {{-- ══════════════════════════════════════════
             MÓDULO 3: LISTADO DE PLANES
             CRUD: READ
             Columna derecha que itera sobre todos
             los planes del usuario autenticado.
             Si no hay planes muestra estado vacío.
        ══════════════════════════════════════════ --}}
        <section class="ahorro-resultados-seccion">

            @forelse($planes as $plan)
                @php
                    // Calcula porcentaje completado (máximo 100%)
                    $porcentaje = $plan->valor_meta > 0
                        ? min(100, round(($plan->ahorro_actual / $plan->valor_meta) * 100))
                        : 0;
                    // Cuánto falta para alcanzar la meta
                    $falta = max(0, $plan->valor_meta - $plan->ahorro_actual);
                @endphp

                <div class="card">

                    {{-- ══════════════════════════════════════════
                         MÓDULO 3A: CABECERA DE CADA PLAN
                         Muestra el nombre del plan y los botones
                         de acción: abonar, retirar, editar, eliminar.
                    ══════════════════════════════════════════ --}}
                    <div class="card-titulo" style="justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <span class="card-icono">🎯</span>
                            <h2>{{ $plan->meta_nombre }}</h2>
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;">

                            {{-- Botón ABONAR: abre modal para sumar monto al ahorro actual --}}
                            <button onclick="abrirAbonar({{ $plan->id }}, '{{ $plan->meta_nombre }}')"
                                    style="background:none;border:none;cursor:pointer;font-size:1.2rem;"
                                    title="Abonar">➕</button>

                            {{-- Botón RETIRAR: abre modal para restar monto al ahorro actual --}}
                            <button onclick="abrirRetirar({{ $plan->id }}, '{{ $plan->meta_nombre }}')"
                                    style="background:none;border:none;cursor:pointer;font-size:1.2rem;"
                                    title="Retirar">➖</button>

                            {{-- Botón EDITAR: abre modal precargado con los datos del plan --}}
                            <button onclick="abrirEditar({{ $plan->id }}, {{ $plan->ahorro_actual }}, '{{ $plan->meta_nombre }}', {{ $plan->valor_meta }}, {{ $plan->plazo_meses }})"
                                    style="background:none;border:none;cursor:pointer;font-size:1.2rem;"
                                    title="Editar plan">✏️</button>

                            {{-- Botón ELIMINAR: envía DELETE con confirmación al usuario --}}
                            <form method="POST" action="{{ route('ahorro.destroy', $plan->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background:none;border:none;cursor:pointer;font-size:1.2rem;color:#FCA5A5;"
                                        title="Eliminar plan"
                                        onclick="return confirm('¿Eliminar este plan?')">🗑️</button>
                            </form>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════
                         MÓDULO 3B: BARRA DE PROGRESO
                         Muestra visualmente cuánto se ha ahorrado
                         respecto a la meta total en porcentaje.
                    ══════════════════════════════════════════ --}}
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

                    {{-- ══════════════════════════════════════════
                         MÓDULO 3C: DESGLOSE DEL PLAN
                         Muestra el plazo en meses y el monto
                         que falta para alcanzar la meta.
                    ══════════════════════════════════════════ --}}
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

                    {{-- ══════════════════════════════════════════
                         MÓDULO 3D: CUOTA MENSUAL SUGERIDA
                         Muestra el ahorro mensual calculado
                         automáticamente por el controlador.
                    ══════════════════════════════════════════ --}}
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
                {{-- ══════════════════════════════════════════
                     MÓDULO 3E: ESTADO VACÍO
                     Se muestra cuando el usuario no tiene
                     ningún plan de ahorro registrado aún.
                ══════════════════════════════════════════ --}}
                <div class="card" style="text-align:center;padding:60px 28px;">
                    <div style="font-size:3rem;margin-bottom:16px;">🎯</div>
                    <h3 style="color:#1F2937;margin-bottom:8px;">Aún no tienes planes de ahorro</h3>
                    <p style="color:#6B7280;font-size:0.9rem;">Crea tu primera meta usando el formulario.</p>
                </div>
            @endforelse

        </section>
    </div>
</main>

{{-- ══════════════════════════════════════════
     MÓDULO 4: MODAL — EDITAR PLAN
     CRUD: UPDATE
     Modal con formulario precargado para modificar
     todos los campos de un plan existente.
     Se abre con abrirEditar() desde JS.
══════════════════════════════════════════ --}}
<div id="modal-editar" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1F2937;border-radius:14px;padding:36px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <h3 style="color:#FBBF24;font-size:1.2rem;margin-bottom:24px;">Editar plan de ahorro</h3>

        <form id="form-editar" method="POST">
            @csrf
            @method('PATCH')

            <div style="margin-bottom:16px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Nombre de la meta</label>
                <input type="text" id="edit-meta-nombre" name="meta_nombre" required
                       style="width:100%;padding:11px 14px;border:1.5px solid #374151;border-radius:8px;background:#111827;color:#FEFCE8;font-size:0.95rem;outline:none;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Meta de ahorro</label>
                <div style="display:flex;align-items:center;border:1.5px solid #374151;border-radius:8px;overflow:hidden;background:#111827;">
                    <span style="padding:11px 12px;background:#374151;color:#9CA3AF;font-weight:700;">$</span>
                    <input type="number" id="edit-valor-meta" name="valor_meta" min="1" required
                           style="flex:1;padding:11px 14px;border:none;background:transparent;color:#FEFCE8;font-size:0.95rem;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Ahorro actual</label>
                <div style="display:flex;align-items:center;border:1.5px solid #374151;border-radius:8px;overflow:hidden;background:#111827;">
                    <span style="padding:11px 12px;background:#374151;color:#9CA3AF;font-weight:700;">$</span>
                    <input type="number" id="edit-ahorro-actual" name="ahorro_actual" min="0" required
                           style="flex:1;padding:11px 14px;border:none;background:transparent;color:#FEFCE8;font-size:0.95rem;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Plazo</label>
                <select id="edit-plazo" name="plazo_meses" required
                        style="width:100%;padding:11px 14px;border:1.5px solid #374151;border-radius:8px;background:#111827;color:#FEFCE8;font-size:0.95rem;outline:none;">
                    <option value="3">3 meses</option>
                    <option value="6">6 meses</option>
                    <option value="12">1 año</option>
                    <option value="18">1 año y medio</option>
                    <option value="24">2 años</option>
                    <option value="36">3 años</option>
                    <option value="48">4 años</option>
                    <option value="60">5 años</option>
                </select>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="button"
                        onclick="document.getElementById('modal-editar').style.display='none'"
                        style="flex:1;padding:11px;background:transparent;color:#9CA3AF;border:1.5px solid #374151;border-radius:7px;font-size:0.95rem;cursor:pointer;font-family:inherit;">
                    Cancelar
                </button>
                <button type="submit"
                        style="flex:1;padding:11px;background:#FBBF24;color:#1F2937;border:none;border-radius:7px;font-size:0.95rem;font-weight:bold;cursor:pointer;font-family:inherit;">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MÓDULO 5: MODAL — ABONAR
     CRUD: UPDATE parcial (incrementa ahorro_actual)
     Modal con campo de monto para registrar
     un depósito al plan seleccionado.
     Se abre con abrirAbonar() desde JS.
══════════════════════════════════════════ --}}
<div id="modal-abonar" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1F2937;border-radius:14px;padding:36px;width:100%;max-width:420px;">
        <h3 style="color:#34D399;font-size:1.2rem;margin-bottom:6px;">Registrar abono</h3>
        <p id="modal-abonar-nombre" style="color:#9CA3AF;font-size:0.9rem;margin-bottom:24px;"></p>

        <form id="form-abonar" method="POST">
            @csrf
            <div style="margin-bottom:18px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Monto a abonar</label>
                <div style="display:flex;align-items:center;border:1.5px solid #374151;border-radius:8px;overflow:hidden;background:#111827;">
                    <span style="padding:11px 12px;background:#374151;color:#9CA3AF;font-weight:700;">$</span>
                    <input type="number" name="monto" placeholder="0" min="1"
                           style="flex:1;padding:11px 14px;border:none;background:transparent;color:#FEFCE8;font-size:0.95rem;outline:none;">
                </div>
            </div>
            <div style="display:flex;gap:12px;">
                <button type="button" onclick="document.getElementById('modal-abonar').style.display='none'"
                        style="flex:1;padding:11px;background:transparent;color:#9CA3AF;border:1.5px solid #374151;border-radius:7px;font-size:0.95rem;cursor:pointer;font-family:inherit;">
                    Cancelar
                </button>
                <button type="submit"
                        style="flex:1;padding:11px;background:#34D399;color:#1F2937;border:none;border-radius:7px;font-size:0.95rem;font-weight:bold;cursor:pointer;font-family:inherit;">
                    Abonar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MÓDULO 6: MODAL — RETIRAR
     CRUD: UPDATE parcial (reduce ahorro_actual)
     Modal con campo de monto para registrar
     un retiro del plan seleccionado.
     Se abre con abrirRetirar() desde JS.
══════════════════════════════════════════ --}}
<div id="modal-retirar" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1F2937;border-radius:14px;padding:36px;width:100%;max-width:420px;">
        <h3 style="color:#FCA5A5;font-size:1.2rem;margin-bottom:6px;">Registrar retiro</h3>
        <p id="modal-retirar-nombre" style="color:#9CA3AF;font-size:0.9rem;margin-bottom:24px;"></p>

        <form id="form-retirar" method="POST">
            @csrf
            <div style="margin-bottom:18px;">
                <label style="display:block;color:#FEFCE8;font-size:0.85rem;font-weight:bold;margin-bottom:6px;">Monto a retirar</label>
                <div style="display:flex;align-items:center;border:1.5px solid #374151;border-radius:8px;overflow:hidden;background:#111827;">
                    <span style="padding:11px 12px;background:#374151;color:#9CA3AF;font-weight:700;">$</span>
                    <input type="number" name="monto" placeholder="0" min="1"
                           style="flex:1;padding:11px 14px;border:none;background:transparent;color:#FEFCE8;font-size:0.95rem;outline:none;">
                </div>
            </div>
            <div style="display:flex;gap:12px;">
                <button type="button" onclick="document.getElementById('modal-retirar').style.display='none'"
                        style="flex:1;padding:11px;background:transparent;color:#9CA3AF;border:1.5px solid #374151;border-radius:7px;font-size:0.95rem;cursor:pointer;font-family:inherit;">
                    Cancelar
                </button>
                <button type="submit"
                        style="flex:1;padding:11px;background:#FCA5A5;color:#1F2937;border:none;border-radius:7px;font-size:0.95rem;font-weight:bold;cursor:pointer;font-family:inherit;">
                    Retirar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MÓDULO 7: JAVASCRIPT — CONTROL DE MODALES
     Funciones que abren cada modal y precargan
     la información del plan correspondiente:
     - abrirEditar(): carga todos los campos
     - abrirAbonar(): asigna ruta y nombre del plan
     - abrirRetirar(): asigna ruta y nombre del plan
══════════════════════════════════════════ --}}
<script>
// Abre modal editar y precarga todos los campos del plan (CRUD: UPDATE)
function abrirEditar(id, ahorroActual, nombre, valorMeta, plazoMeses) {
    document.getElementById('form-editar').action = '/ahorro/' + id;
    document.getElementById('edit-meta-nombre').value = nombre;
    document.getElementById('edit-valor-meta').value = valorMeta;
    document.getElementById('edit-ahorro-actual').value = ahorroActual;
    document.getElementById('edit-plazo').value = plazoMeses;
    document.getElementById('modal-editar').style.display = 'flex';
}

// Abre modal abonar y asigna ruta correcta (CRUD: UPDATE parcial)
function abrirAbonar(id, nombre) {
    document.getElementById('form-abonar').action = '/ahorro/' + id + '/abonar';
    document.getElementById('modal-abonar-nombre').textContent = 'Meta: ' + nombre;
    document.getElementById('modal-abonar').style.display = 'flex';
}

// Abre modal retirar y asigna ruta correcta (CRUD: UPDATE parcial)
function abrirRetirar(id, nombre) {
    document.getElementById('form-retirar').action = '/ahorro/' + id + '/retirar';
    document.getElementById('modal-retirar-nombre').textContent = 'Meta: ' + nombre;
    document.getElementById('modal-retirar').style.display = 'flex';
}
</script>

@endsection