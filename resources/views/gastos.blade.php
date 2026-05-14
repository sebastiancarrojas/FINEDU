<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finedu</title>
    <link rel="stylesheet" href="{{ asset('css/gastos.css') }}">
</head>
<body>

<main class="gastos-main">

    <!-- ENCABEZADO -->
    <div class="gastos-header">
        <div class="gastos-header-texto">
            <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al inicio</a>
            <h1>Planificador de <span>Gastos</span></h1>
            <p>Organiza y distribuye tus gastos de forma equilibrada.</p>
        </div>
    </div>

    <div class="gastos-contenedor">

        <!-- COLUMNA IZQUIERDA -->
        <aside class="gastos-sidebar">

            <!-- SELECTOR DE MES -->
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">📅</span>
                    <h2>Mes actual</h2>
                </div>
                <div class="campo">
                    <label for="mes">Selecciona el mes</label>
                    <div class="select-wrapper">
                        <select id="mes">
                            <option>Enero 2025</option>
                            <option>Febrero 2025</option>
                            <option>Marzo 2025</option>
                            <option>Abril 2025</option>
                            <option selected>Mayo 2025</option>
                            <option>Junio 2025</option>
                            <option>Julio 2025</option>
                            <option>Agosto 2025</option>
                            <option>Septiembre 2025</option>
                            <option>Octubre 2025</option>
                            <option>Noviembre 2025</option>
                            <option>Diciembre 2025</option>
                        </select>
                        <span class="select-arrow">▾</span>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO AGREGAR GASTO -->
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">➕</span>
                    <h2>Agregar gasto</h2>
                </div>

                <div class="campo">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" value="2025-05-03">
                </div>

                <div class="campo">
                    <label for="categoria">Categoría</label>
                    <div class="select-wrapper">
                        <select id="categoria">
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="alimentacion">🍽️ Alimentación</option>
                            <option value="transporte">🚌 Transporte</option>
                            <option value="vivienda">🏠 Vivienda</option>
                            <option value="entretenimiento">🎬 Entretenimiento</option>
                            <option value="otros">📦 Otros</option>
                        </select>
                        <span class="select-arrow">▾</span>
                    </div>
                </div>

                <div class="campo">
                    <label for="valor">Valor del gasto</label>
                    <div class="input-prefix-wrapper">
                        <span class="input-prefix">$</span>
                        <input type="number" id="valor" placeholder="0.00" min="0">
                    </div>
                </div>

                <button class="btn-agregar" tabindex="-1">Agregar gasto</button>
            </div>

            <!-- RESUMEN -->
            <div class="card card-resumen">
                <div class="card-titulo">
                    <span class="card-icono">📊</span>
                    <h2>Resumen — Mayo 2025</h2>
                </div>
                <div class="resumen-lista">
                    <div class="resumen-fila">
                        <span>🍽️ Alimentación</span>
                        <strong>$620.000</strong>
                    </div>
                    <div class="resumen-fila">
                        <span>🚌 Transporte</span>
                        <strong>$310.000</strong>
                    </div>
                    <div class="resumen-fila">
                        <span>🏠 Vivienda</span>
                        <strong>$800.000</strong>
                    </div>
                    <div class="resumen-fila">
                        <span>🎬 Entretenimiento</span>
                        <strong>$175.000</strong>
                    </div>
                    <div class="resumen-fila">
                        <span>📦 Otros</span>
                        <strong>$140.000</strong>
                    </div>
                </div>
                <div class="resumen-total">
                    <span>Total del mes</span>
                    <strong>$2.045.000</strong>
                </div>
            </div>

        </aside>

        <!-- COLUMNA DERECHA: Tabla -->
        <section class="gastos-tabla-seccion">
            <div class="card">
                <div class="card-titulo">
                    <span class="card-icono">📋</span>
                    <h2>Gastos — Mayo 2025</h2>
                    <span class="badge">10 registros</span>
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
                            <tr>
                                <td class="td-num">1</td>
                                <td class="td-fecha">01 may</td>
                                <td><span class="tag tag-transporte">🚌 Transporte</span></td>
                                <td class="td-valor">$12.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">2</td>
                                <td class="td-fecha">01 may</td>
                                <td><span class="tag tag-alimentacion">🍽️ Alimentación</span></td>
                                <td class="td-valor">$35.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">3</td>
                                <td class="td-fecha">02 may</td>
                                <td><span class="tag tag-transporte">🚌 Transporte</span></td>
                                <td class="td-valor">$12.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">4</td>
                                <td class="td-fecha">02 may</td>
                                <td><span class="tag tag-alimentacion">🍽️ Alimentación</span></td>
                                <td class="td-valor">$28.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">5</td>
                                <td class="td-fecha">03 may</td>
                                <td><span class="tag tag-vivienda">🏠 Vivienda</span></td>
                                <td class="td-valor">$800.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">6</td>
                                <td class="td-fecha">03 may</td>
                                <td><span class="tag tag-transporte">🚌 Transporte</span></td>
                                <td class="td-valor">$15.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">7</td>
                                <td class="td-fecha">04 may</td>
                                <td><span class="tag tag-entretenimiento">🎬 Entretenimiento</span></td>
                                <td class="td-valor">$55.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">8</td>
                                <td class="td-fecha">04 may</td>
                                <td><span class="tag tag-alimentacion">🍽️ Alimentación</span></td>
                                <td class="td-valor">$42.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">9</td>
                                <td class="td-fecha">05 may</td>
                                <td><span class="tag tag-otros">📦 Otros</span></td>
                                <td class="td-valor">$140.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-num">10</td>
                                <td class="td-fecha">05 may</td>
                                <td><span class="tag tag-entretenimiento">🎬 Entretenimiento</span></td>
                                <td class="td-valor">$120.000</td>
                                <td class="td-acciones">
                                    <button class="btn-editar" tabindex="-1">✏️ Editar</button>
                                    <button class="btn-eliminar" tabindex="-1">🗑️ Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

    </div>

</main>