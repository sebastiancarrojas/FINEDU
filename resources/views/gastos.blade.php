@extends('layouts.dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('css/gastos.css') }}">

{{-- ══════════════════════════════════════════
     MÓDULO 1: ENCABEZADO DE LA PÁGINA
     Muestra el título, subtítulo descriptivo
     y el botón para regresar al dashboard.
══════════════════════════════════════════ --}}
<div class="gastos-header">
    <div class="gastos-header-texto">
        <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
        <h1>Planificador de <span>Gastos</span></h1>
        <p>Organiza y distribuye tus gastos de forma equilibrada.</p>
    </div>
</div>

{{-- Mensaje flash de éxito (store, update, destroy) --}}
@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="gastos-contenedor">

    <aside class="gastos-sidebar">

        {{-- ══════════════════════════════════════════
             MÓDULO 2: SELECTOR DE MES
             Permite al usuario cambiar el mes que
             está visualizando. Al cambiar el select,
             redirige a la misma ruta con ?mes=YYYY-MM.
             SESSION: El controlador recuerda el último
             mes consultado para no perder el contexto.
        ══════════════════════════════════════════ --}}
        <div class="card">
            <div class="card-titulo">
                <span class="card-icono">📅</span>
                <h2>Mes actual</h2>
            </div>
            <div class="campo">
                <label for="mes">Selecciona el mes</label>
                <div class="select-wrapper">
                    <select id="mes" onchange="window.location.href='{{ route('gastos') }}?mes='+this.value">
                        @foreach(range(1, 12) as $m)
                            @php
                                $valor  = now()->year . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
                                $nombre = \Carbon\Carbon::parse($valor.'-01')->translatedFormat('F Y');
                            @endphp
                            <option value="{{ $valor }}" {{ $mes == $valor ? 'selected' : '' }}>
                                {{ ucfirst($nombre) }}
                            </option>
                        @endforeach
                    </select>
                    <span class="select-arrow">▾</span>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             MÓDULO 3: FORMULARIO — AGREGAR GASTO
             CRUD: CREATE
             Formulario para registrar un nuevo gasto.
             Envía a GastoController@store via POST.
             COOKIE: La categoría seleccionada se guarda
             en el controlador y se pre-selecciona aquí
             la próxima vez usando $categoriaFavorita.
        ══════════════════════════════════════════ --}}
        <div class="card">
            <div class="card-titulo">
                <span class="card-icono">➕</span>
                <h2>Agregar gasto</h2>
            </div>

            <form method="POST" action="{{ route('gastos.store') }}">
                @csrf

                {{-- Campo fecha: por defecto el día de hoy --}}
                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha"
                           value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                </div>

                {{-- Campo categoría: pre-selecciona la última usada via COOKIE --}}
                <div class="campo">
                    <label for="categoria_id">Categoría</label>
                    <div class="select-wrapper">
                        <select id="categoria_id" name="categoria_id" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}"
                                    {{-- Prioridad: error de validación > cookie categoria_favorita --}}
                                    {{ old('categoria_id', $categoriaFavorita) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->emoji }} {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <span class="select-arrow">▾</span>
                    </div>
                </div>

                {{-- Campo valor: monto del gasto en pesos colombianos --}}
                <div class="campo">
                    <label for="valor">Valor del gasto</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="valor" name="valor"
                               placeholder="0.00" min="0" step="0.01" required>
                    </div>
                </div>

                <button type="submit" class="btn-agregar">Agregar gasto</button>
            </form>
        </div>

        {{-- ══════════════════════════════════════════
             MÓDULO 4: RESUMEN DEL MES
             CRUD: READ (agregado por categoría)
             Muestra el total gastado por categoría
             y el gran total del mes seleccionado.
             Los datos vienen del controlador como
             $resumen (agrupado) y $total (suma).
        ══════════════════════════════════════════ --}}
        <div class="card card-resumen">
            <div class="card-titulo">
                <span class="card-icono">📊</span>
                <h2>Resumen — {{ ucfirst(\Carbon\Carbon::parse($mes.'-01')->translatedFormat('F Y')) }}</h2>
            </div>
            <div class="resumen-lista">
                @foreach($categorias as $cat)
                    @if(isset($resumen[$cat->id]))
                        <div class="resumen-fila">
                            <span>{{ $cat->emoji }} {{ $cat->nombre }}</span>
                            <strong>${{ number_format($resumen[$cat->id], 0, ',', '.') }}</strong>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="resumen-total">
                <span>Total del mes</span>
                <strong>${{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════
         MÓDULO 5: TABLA DE GASTOS
         CRUD: READ
         Lista todos los gastos del mes seleccionado
         con fecha, categoría, valor y acciones.
         Si no hay gastos muestra estado vacío.
         Cada fila tiene botones de editar y eliminar.
    ══════════════════════════════════════════ --}}
    <section class="gastos-tabla-seccion">
        <div class="card">
            <div class="card-titulo">
                <span class="card-icono">📋</span>
                <h2>Gastos — {{ ucfirst(\Carbon\Carbon::parse($mes.'-01')->translatedFormat('F Y')) }}</h2>
                <span class="badge">{{ $gastos->count() }} registros</span>
            </div>

            <div class="tabla-wrapper">
                <table class="tabla-gastos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Categoría</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gastos as $i => $gasto)
                            <tr>
                                <td class="td-num">{{ $i + 1 }}</td>
                                <td class="td-fecha">{{ \Carbon\Carbon::parse($gasto->fecha)->format('d M') }}</td>
                                <td>
                                    <span class="tag tag-{{ $gasto->categoria->slug ?? '' }}">
                                        {{ $gasto->categoria->emoji ?? '' }} {{ $gasto->categoria->nombre ?? 'Sin categoría' }}
                                    </span>
                                </td>
                                <td class="td-valor">${{ number_format($gasto->valor, 0, ',', '.') }}</td>
                                <td class="td-acciones">

                                    {{-- Botón EDITAR: abre modal precargado con datos del gasto --}}
                                    <button class="btn-editar"
                                            onclick="abrirEditar({{ $gasto->id }}, '{{ $gasto->fecha }}', {{ $gasto->categoria_id }}, {{ $gasto->valor }})">
                                        ✏️ Editar
                                    </button>

                                    {{-- Botón ELIMINAR: envía DELETE con confirmación --}}
                                    <form method="POST"
                                          action="{{ route('gastos.destroy', $gasto) }}"
                                          onsubmit="return confirm('¿Eliminar este gasto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-eliminar">🗑️ Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            {{-- Estado vacío: no hay gastos en el mes seleccionado --}}
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 30px; color: #9CA3AF;">
                                    No hay gastos registrados para este mes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</div>

{{-- ══════════════════════════════════════════
     MÓDULO 6: MODAL — EDITAR GASTO
     CRUD: UPDATE
     Modal con formulario precargado para modificar
     fecha, categoría y valor de un gasto existente.
     Se abre con abrirEditar() desde JS.
     Envía a GastoController@update via PUT.
══════════════════════════════════════════ --}}
<div class="modal-overlay" id="modal-editar" style="display:none;">
    <div class="modal">

        {{-- Botón cerrar modal --}}
        <a href="#" class="modal-close" title="Cerrar"
           onclick="document.getElementById('modal-editar').style.display='none'; return false;">✕</a>

        <div class="modal-logo">Editar Gasto</div>

        <form method="POST" id="form-editar" action="">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="edit-fecha">Fecha</label>
                <input type="date" id="edit-fecha" name="fecha" required>
            </div>

            <div class="form-group">
                <label for="edit-categoria">Categoría</label>
                <select id="edit-categoria" name="categoria_id" required>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->emoji }} {{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit-valor">Valor</label>
                <input type="number" id="edit-valor" name="valor" min="0" step="0.01" required>
            </div>

            <button type="submit" class="btn-submit">Guardar cambios</button>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     MÓDULO 7: JAVASCRIPT — CONTROL DEL MODAL
     Función abrirEditar() que precarga los datos
     del gasto seleccionado en el modal de edición:
     - Asigna la ruta PUT correcta al formulario
     - Rellena fecha, categoría y valor automáticamente
══════════════════════════════════════════ --}}
<script>
// Abre el modal de edición y precarga los datos del gasto (CRUD: UPDATE)
function abrirEditar(id, fecha, categoriaId, valor) {
    document.getElementById('form-editar').action = '/gastos/' + id;
    document.getElementById('edit-fecha').value        = fecha;
    document.getElementById('edit-categoria').value    = categoriaId;
    document.getElementById('edit-valor').value        = valor;
    document.getElementById('modal-editar').style.display = 'flex';
}
</script>

@endsection