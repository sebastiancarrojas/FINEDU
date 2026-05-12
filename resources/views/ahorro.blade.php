<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finedu</title>
    <link rel="stylesheet" href="{{ asset('css/ahorro.css') }}">
</head>
<body>

<main class="ahorro-main">

    <!-- ENCABEZADO -->
    <div class="ahorro-header">
        <div class="ahorro-header-texto">
            <a href="dashboard.php" class="btn-volver">← Volver al inicio</a>
            <h1>Plan de <span>Ahorro</span></h1>
            <p>Define tu meta, el plazo y descubre cuánto debes ahorrar cada mes.</p>
        </div>
    </div>

    <div class="ahorro-contenedor">

        <!-- COLUMNA IZQUIERDA: Entradas -->
        <aside class="ahorro-sidebar">

            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">🎯</span>
                    <h2>Define tu meta</h2>
                </div>

                <div class="campo">
                    <label for="meta">Meta de ahorro</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="meta" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="ahorro-actual">Ahorro actual</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="ahorro-actual" placeholder="0" min="0">
                    </div>
                </div>

                <div class="campo">
                    <label for="plazo">Plazo</label>
                    <div class="select-wrapper">
                        <select id="plazo">
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

                <button class="btn-calcular">Calcular plan</button>

            </div>

        </aside>

        <!-- COLUMNA DERECHA: Resultados -->
        <section class="ahorro-resultados-seccion">

            <!-- Progreso visual -->
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">📊</span>
                    <h2>Progreso hacia tu meta</h2>
                </div>

                <div class="progreso-labels">
                    <span>Ahorro actual: <strong id="res-ahorro-actual">$0</strong></span>
                    <span>Meta: <strong id="res-meta">$0</strong></span>
                </div>

                <div class="barra-fondo">
                    <div class="barra-progreso" id="barra-progreso" style="width: 0%"></div>
                </div>

                <div class="progreso-porcentaje">
                    <span id="res-porcentaje">0%</span> completado
                </div>

            </div>

            <!-- Desglose -->
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">📋</span>
                    <h2>Desglose del plan</h2>
                </div>

                <div class="resultado-lista">
                    <div class="resultado-fila">
                        <span>🎯 Meta total</span>
                        <strong id="res-meta-desglose">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>✅ Ya tienes ahorrado</span>
                        <strong id="res-ya-ahorrado">$0</strong>
                    </div>
                    <div class="resultado-fila">
                        <span>⏳ Plazo seleccionado</span>
                        <strong id="res-plazo">— meses</strong>
                    </div>
                </div>

                <div class="resultado-subtotal">
                    <span>Falta por ahorrar</span>
                    <strong id="res-falta">$0</strong>
                </div>
            </div>

            <!-- Cuota mensual -->
            <div class="card card-cuota">
                <div class="card-titulo">
                    <span class="card-icono">💰</span>
                    <h2>Debes ahorrar cada mes</h2>
                </div>
                <div class="cuota-valor">
                    <span id="res-cuota">$0</span>
                </div>
                <p class="cuota-nota">durante <strong id="res-plazo-nota">— meses</strong> para alcanzar tu meta</p>
            </div>

        </section>

    </div>

</main>