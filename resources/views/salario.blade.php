<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finedu</title>
    <link rel="stylesheet" href="{{ asset('css/salario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<main class="salario-main">

    <!-- ENCABEZADO -->
    <div class="salario-header">
        <div class="salario-header-texto">
            <a href="dashboard.php" class="btn-volver">← Volver al inicio</a>
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
                    <label for="salario-base">Salario base</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="salario-base" placeholder="0" min="0">
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
                        <span class="input-prefix">$</span>
                        <input type="number" id="horas-extras" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="nocturnos">Recargos nocturnos</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="nocturnos" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="dominicales">Dominicales / Festivos</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="dominicales" placeholder="0" min="0">
                    </div>
                </div>

                <button class="btn-calcular">Calcular salario</button>

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