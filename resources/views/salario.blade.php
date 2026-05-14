@extends('layouts.app')

@section('content')

<main class="salario-main">

    <!-- ENCABEZADO -->
    <div class="salario-header">
        <div class="salario-header-texto">
            <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
            <h1>Calculadora de <span>Salario</span></h1>
            <p>Calcula tu salario neto con todos tus ingresos y deducciones de ley.</p>
        </div>
    </div>

    <div class="salario-contenedor">

        <!-- COLUMNA IZQUIERDA: Entradas -->
        <aside class="salario-sidebar">
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">💵</span>
                    <h2>Ingresos</h2>
                </div>

                <div class="campo">
                    <label for="salario-base">Salario Base Quincenal</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="salario-base" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="salario-base">Auxilio de Transporte</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="auxilio" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="bonos">Bonos / Comisiones</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="bonos" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="horas-extras">Horas extras</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="horas-extras" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="nocturnos">Horas Nocturnas</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="nocturnos" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="dominicales">Horas Dominicales / Festivos</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix"> </span>
                        <input type="number" id="dominicales" placeholder="0" min="0">
                    </div>
                </div>

                <button class="btn-calcular" onclick="calcularSalario()">Calcular salario</button>

            </div>
        </aside>

        <!-- COLUMNA DERECHA: Resultados -->
        <section class="salario-resultados-seccion">

            <!-- Devengado -->
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

            <!-- Deducciones -->
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

            <!-- Neto -->
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

<link rel="stylesheet" href="{{ asset('css/salario.css') }}">

<script>
function fmt(valor) {
    return '$' + Math.round(valor).toLocaleString('es-CO');
}

function val(id) {
    return parseFloat(document.getElementById(id).value) || 0;
}

function calcularSalario() {
    // Ingresos
    const base        = val('salario-base');
    const bonos       = val('bonos');
    const extras      = val('horas-extras');
    const nocturnos   = val('nocturnos');
    const dominicales = val('dominicales');
    const auxilio     = val('auxilio');

    
    const devengado = base + bonos + (extras*9153) + (nocturnos*2918) + (dominicales*6367) + auxilio;

    // Deducciones sobre salario base (según ley colombiana)
    const salud   = (base + bonos + nocturnos + dominicales) * 0.04;
    const pension = (base + bonos + nocturnos + dominicales) * 0.04;
    const totalDeducciones = salud + pension;

    const neto = devengado - totalDeducciones;

    // Actualizar resultados
    document.getElementById('res-base').textContent       = fmt(base);
    document.getElementById('res-bonos').textContent      = fmt(bonos);
    document.getElementById('res-extras').textContent     = fmt(extras*9153);
    document.getElementById('res-nocturnos').textContent  = fmt(nocturnos*2918);
    document.getElementById('res-dominicales').textContent = fmt(dominicales*6367);
    document.getElementById('res-devengado').textContent  = fmt(devengado);

    document.getElementById('res-salud').textContent      = '-' + fmt(salud);
    document.getElementById('res-pension').textContent    = '-' + fmt(pension);
    document.getElementById('res-deducciones').textContent = '-' + fmt(totalDeducciones);

    document.getElementById('res-neto').textContent       = fmt(neto);

    // Guardar en sessionStorage (se borra al cerrar el navegador)
    sessionStorage.setItem('salario_ultimo', JSON.stringify({
        base, bonos, extras, nocturnos, dominicales, devengado, salud, pension, neto
    }));
}

// Restaurar último cálculo si existe en esta sesión
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