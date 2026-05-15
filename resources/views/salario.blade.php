@extends('layouts.dashboard')

@section('content')

<main class="salario-main">

    {{-- ══════════════════════════════════════════
         MÓDULO 1: ENCABEZADO DE LA PÁGINA
         Muestra el título, subtítulo descriptivo
         y el botón para regresar al dashboard.
    ══════════════════════════════════════════ --}}
    <div class="salario-header">
        <div class="salario-header-texto">
            <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
            <h1>Calculadora de <span>Salario</span></h1>
            <p>Calcula tu salario neto con todos tus ingresos y deducciones de ley.</p>
        </div>
    </div>

    <div class="salario-contenedor">

        {{-- ══════════════════════════════════════════
             MÓDULO 2: FORMULARIO DE INGRESOS
             Sidebar izquierdo con los campos de entrada.
             No usa controlador ni base de datos;
             toda la lógica es del lado del cliente (JS).
             Campos monetarios ($): salario, auxilio, bonos.
             Campos numéricos (sin $): horas extras,
             nocturnas y dominicales (son cantidades, no montos).
        ══════════════════════════════════════════ --}}
        <aside class="salario-sidebar">
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">💵</span>
                    <h2>Ingresos</h2>
                </div>

                {{-- Campo monetario: base del cálculo principal --}}
                <div class="campo">
                    <label for="salario-base">Salario Base Quincenal</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="salario-base" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Campo monetario: solo aplica si salario < 2 SMMLV --}}
                <div class="campo">
                    <label for="auxilio">Auxilio de Transporte</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="auxilio" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Campo monetario: comisiones o bonificaciones adicionales --}}
                <div class="campo">
                    <label for="bonos">Bonos / Comisiones</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="bonos" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Campo numérico: cantidad de horas (el JS multiplica por valor hora) --}}
                <div class="campo">
                    <label for="horas-extras">Horas extras</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="horas-extras" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Campo numérico: cantidad de horas nocturnas trabajadas --}}
                <div class="campo">
                    <label for="nocturnos">Horas Nocturnas</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="nocturnos" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Campo numérico: cantidad de horas en domingos o festivos --}}
                <div class="campo">
                    <label for="dominicales">Horas Dominicales / Festivos</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="dominicales" placeholder="0" min="0">
                    </div>
                </div>

                {{-- Botón que dispara calcularSalario() en el módulo JS --}}
                <button class="btn-calcular" onclick="calcularSalario()">Calcular salario</button>

            </div>
        </aside>

        {{-- ══════════════════════════════════════════
             MÓDULO 3: PANEL DE RESULTADOS
             Columna derecha con tres tarjetas:
             devengado, deducciones y salario neto.
             Los valores se actualizan desde JS con
             document.getElementById().textContent.
        ══════════════════════════════════════════ --}}
        <section class="salario-resultados-seccion">

            {{-- ══════════════════════════════════════════
                 MÓDULO 3A: DESGLOSE DE INGRESOS
                 Muestra el valor calculado de cada
                 concepto y el total devengado.
                 Valores hora usados (SMMLV 2025):
                 - Extra diurna:    $9.153
                 - Nocturna:        $2.918
                 - Dominical:       $6.367
            ══════════════════════════════════════════ --}}
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">📋</span>
                    <h2>Desglose de ingresos</h2>
                </div>
                <div class="resultado-lista">
                    <div class="resultado-fila">
                        <span>💵 Salario base</span>
                        <strong id="res-base">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>🎯 Bonos / Comisiones</span>
                        <strong id="res-bonos">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>⏰ Horas extras</span>
                        <strong id="res-extras">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>🌙 Recargos nocturnos</span>
                        <strong id="res-nocturnos">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>📅 Dominicales / Festivos</span>
                        <strong id="res-dominicales">$0</strong>
                    </div>
                </div>
                <div class="resultado-subtotal">
                    <span>Total devengado</span>
                    <strong id="res-devengado">$0</strong>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 MÓDULO 3B: DEDUCCIONES DE LEY
                 Calcula y muestra los descuentos
                 obligatorios según ley colombiana:
                 - Salud:   4% sobre base + bonos
                 - Pensión: 4% sobre base + bonos
                 El auxilio de transporte NO es base
                 de cotización, por eso se excluye.
            ══════════════════════════════════════════ --}}
            <div class="card card-deducciones">
                <div class="card-titulo">
                    <span class="card-icono">📉</span>
                    <h2>Deducciones de ley</h2>
                </div>
                <div class="resultado-lista">
                    <div class="resultado-fila">
                        <span>🏥 Salud (4%)</span>
                        <strong id="res-salud" class="valor-deduccion">-$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>👴 Pensión (4%)</span>
                        <strong id="res-pension" class="valor-deduccion">-$0</strong>
                    </div>
                </div>
                <div class="resultado-subtotal subtotal-deduccion">
                    <span>Total deducciones</span>
                    <strong id="res-deducciones">-$0</strong>
                </div>
            </div>

            {{-- ══════════════════════════════════════════
                 MÓDULO 3C: SALARIO NETO
                 Muestra el resultado final:
                 Neto = Devengado - Total deducciones
            ══════════════════════════════════════════ --}}
            <div class="card card-neto">
                <div class="card-titulo">
                    <span class="card-icono">✅</span>
                    <h2>Salario neto a recibir</h2>
                </div>
                <div class="neto-valor">
                    <span id="res-neto">$0</span>
                </div>
            </div>

        </section>
    </div>
</main>

{{-- CSS cargado al final para no bloquear el render --}}
<link rel="stylesheet" href="{{ asset('css/salario.css') }}">

{{-- ══════════════════════════════════════════
     MÓDULO 4: JAVASCRIPT — LÓGICA DE CÁLCULO
     Toda la lógica corre en el navegador (client-side).
     No hay peticiones al servidor ni controladores.

     Funciones principales:
     - fmt(valor):       formatea número a pesos colombianos
     - val(id):          lee y parsea el valor de un input
     - calcularSalario(): ejecuta el cálculo completo y
                          actualiza todos los resultados en pantalla

     sessionStorage:
     - Guarda el último cálculo al calcular.
     - Lo restaura automáticamente al recargar la página.
     - Se borra al cerrar el navegador (a diferencia de localStorage).
══════════════════════════════════════════ --}}
<script>
// Formatea un número como pesos colombianos: $1.234.567
function fmt(valor) {
    return '$' + Math.round(valor).toLocaleString('es-CO');
}

// Lee el valor numérico de un input por su ID (0 si está vacío)
function val(id) {
    return parseFloat(document.getElementById(id).value) || 0;
}

function calcularSalario() {
    // Leer todos los inputs del Módulo 2
    const base        = val('salario-base');
    const bonos       = val('bonos');
    const extras      = val('horas-extras');
    const nocturnos   = val('nocturnos');
    const dominicales = val('dominicales');
    const auxilio     = val('auxilio');

    // Total devengado: suma de todos los ingresos
    // Valores hora según SMMLV 2025 colombiano
    const devengado = base + bonos + (extras * 9153) + (nocturnos * 2918) + (dominicales * 6367) + auxilio;

    // Deducciones: 4% salud + 4% pensión sobre base cotizable
    // El auxilio de transporte NO cotiza según ley colombiana
    const salud           = (base + bonos + nocturnos + dominicales) * 0.04;
    const pension         = (base + bonos + nocturnos + dominicales) * 0.04;
    const totalDeducciones = salud + pension;

    // Salario neto final
    const neto = devengado - totalDeducciones;

    // Actualizar Módulo 3A: desglose de ingresos
    document.getElementById('res-base').textContent        = fmt(base);
    document.getElementById('res-bonos').textContent       = fmt(bonos);
    document.getElementById('res-extras').textContent      = fmt(extras * 9153);
    document.getElementById('res-nocturnos').textContent   = fmt(nocturnos * 2918);
    document.getElementById('res-dominicales').textContent = fmt(dominicales * 6367);
    document.getElementById('res-devengado').textContent   = fmt(devengado);

    // Actualizar Módulo 3B: deducciones
    document.getElementById('res-salud').textContent       = '-' + fmt(salud);
    document.getElementById('res-pension').textContent     = '-' + fmt(pension);
    document.getElementById('res-deducciones').textContent = '-' + fmt(totalDeducciones);

    // Actualizar Módulo 3C: neto
    document.getElementById('res-neto').textContent        = fmt(neto);

    // sessionStorage: persiste el cálculo durante la sesión del navegador
    sessionStorage.setItem('salario_ultimo', JSON.stringify({
        base, bonos, extras, nocturnos, dominicales, devengado, salud, pension, neto
    }));
}

// Al cargar la página, restaurar el último cálculo si existe en sessionStorage
document.addEventListener('DOMContentLoaded', function () {
    const guardado = sessionStorage.getItem('salario_ultimo');
    if (guardado) {
        const d = JSON.parse(guardado);
        document.getElementById('salario-base').value  = d.base;
        document.getElementById('bonos').value         = d.bonos;
        document.getElementById('horas-extras').value  = d.extras;
        document.getElementById('nocturnos').value     = d.nocturnos;
        document.getElementById('dominicales').value   = d.dominicales;
        calcularSalario();
    }
});
</script>

@endsection