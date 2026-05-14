@php
    $destino = auth()->check() ? route('dashboard') : null;
@endphp

<section class="seccion-bienvenida" id="inicio">
    <div class="slider-container">

        <div class="slider-puntos">
            <a href="#slide-1"></a>
            <a href="#slide-2"></a>
            <a href="#slide-3"></a>
        </div>

        <div class="slider-wrapper">
            <article class="slide" id="slide-1">
                <div class="contenido-texto">
                    <span class="etiqueta-servicio">Ahorro</span>
                    <h2>Tu Plan de Ahorro <br> a un clic</h2>
                    <p>No dejes tus sueños al azar. Proyecta cuánto puedes ahorrar mensualmente y alcanza tus metas financieras.</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-cta">Empezar ahora</a>
                    @else
                        <a href="#" class="btn-cta"
                           onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                            Empezar ahora
                        </a>
                    @endauth
                </div>
                <div class="contenido-imagen">
                    <img src="imagenes/Ahorro.png" alt="Ahorro y Finanzas">
                </div>
            </article>

            <article class="slide" id="slide-2">
                <div class="contenido-texto">
                    <span class="etiqueta-servicio">Calcular</span>
                    <h2>¿Sabes cuánto <br> ganas realmente?</h2>
                    <p>Calcula tu salario neto después de aportes a salud y pensión. Transparencia total para tu bolsillo.</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-cta">Calcular Salario</a>
                    @else
                        <a href="#" class="btn-cta"
                           onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                            Calcular Salario
                        </a>
                    @endauth
                </div>
                <div class="contenido-imagen">
                    <img src="imagenes/Calcular.png" alt="Calculadora Financiera">
                </div>
            </article>

            <article class="slide" id="slide-3">
                <div class="contenido-texto">
                    <span class="etiqueta-servicio">Planificar</span>
                    <h2>Ordena tus finanzas <br> y vive tranquilo</h2>
                    <p>Crea un esquema de tus gastos y conserva una salud financiera adecuada</p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-cta">Crear Esquema</a>
                    @else
                        <a href="#" class="btn-cta"
                           onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                            Crear Esquema
                        </a>
                    @endauth
                </div>
                <div class="contenido-imagen">
                    <img src="imagenes/Planificacion.png" alt="Calculadora Financiera">
                </div>
            </article>
        </div>
    </div>
</section>

<section class="seccion-servicios" id="servicios">
    <div class="contenedor-servicios">
        <div class="texto-introduccion">
            <h2 class="titulo-principal">Nuestras Herramientas Financieras</h2>
            <p class="descripcion-corta">Gestiona tu dinero de forma inteligente con nuestros módulos especializados.</p>
        </div>
        <div class="grid-servicios">
            <div class="tarjeta-servicio">
                <div class="icono-servicio">💵</div>
                <h3>Simulador de Salario</h3>
                <p>Calcula tus ingresos netos y deducciones de ley de forma automática.</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="enlace-servicio">Probar módulo ➔</a>
                @else
                    <a href="#" class="enlace-servicio"
                       onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                        Probar módulo ➔
                    </a>
                @endauth
            </div>

            <div class="tarjeta-servicio">
                <div class="icono-servicio">🎯</div>
                <h3>Proyección de Ahorro</h3>
                <p>Define una meta y nosotros te diremos cuánto debes guardar cada mes.</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="enlace-servicio">Probar módulo ➔</a>
                @else
                    <a href="#" class="enlace-servicio"
                       onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                        Probar módulo ➔
                    </a>
                @endauth
            </div>

            <div class="tarjeta-servicio">
                <div class="icono-servicio">📊</div>
                <h3>Gasto Mensual</h3>
                <p>Organiza tus gastos fijos y variables para que no te falte dinero al final del mes.</p>
                @auth
                    <a href="{{ route('dashboard') }}" class="enlace-servicio">Probar módulo ➔</a>
                @else
                    <a href="#" class="enlace-servicio"
                       onclick="document.getElementById('modal-login').style.display='flex'; return false;">
                        Probar módulo ➔
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN ACERCA -->
<section class="seccion-acerca" id="acerca">
    <div class="acerca-contenedor">
        <div class="acerca-texto">
            <span class="etiqueta-acerca">Quiénes somos</span>
            <h2>Finanzas inteligentes <br>para todos</h2>
            <p>Finedu es una aplicación web desarrollada en PHP con el objetivo de ayudar a las personas a manejar mejor su dinero de forma sencilla, sin necesidad de conocimientos financieros avanzados.</p>
            <p>Cualquier usuario puede entender cómo se distribuye su salario, definir metas de ahorro y organizar sus gastos de manera equilibrada, todo en un solo lugar accesible y gratuito.</p>
            <div class="acerca-stats">
                <div class="stat">
                    <span class="stat-numero">3+</span>
                    <span class="stat-label">Módulos financieros</span>
                </div>
                <div class="stat">
                    <span class="stat-numero">100%</span>
                    <span class="stat-label">Gratuito</span>
                </div>
                <div class="stat">
                    <span class="stat-numero">🇨🇴</span>
                    <span class="stat-label">Hecho en Colombia</span>
                </div>
            </div>
        </div>
        <div class="acerca-valores">
            <div class="valor-card">
                <div class="valor-icono">🎯</div>
                <h3>Objetivo</h3>
                <p>Desarrollar una aplicación web que permita a los usuarios gestionar mejor su dinero mediante herramientas de cálculo de salario, planificación de ahorro y organización de gastos.</p>
            </div>
            <div class="valor-card">
                <div class="valor-icono">💡</div>
                <h3>Justificación</h3>
                <p>Muchas personas no tienen claridad sobre su salario real ni saben cómo organizar sus gastos. Finedu ofrece una alternativa accesible a la asesoría financiera profesional, mejorando los hábitos económicos de quienes la usan.</p>
            </div>
            <div class="valor-card">
                <div class="valor-icono">🏆</div>
                <h3>Resultado esperado</h3>
                <p>Que los usuarios logren organizar sus gastos, ahorrar de forma más efectiva y tener mayor control sobre su dinero gracias a herramientas simples y visuales.</p>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN CONTACTO -->
<section class="seccion-contacto" id="contacto">
    <div class="contacto-contenedor">
        <div class="contacto-info">
            <span class="etiqueta-contacto">Escríbenos</span>
            <h2>¿Tienes alguna pregunta?</h2>
            <p>Estamos aquí para ayudarte. Completa el formulario y nos pondremos en contacto contigo pronto.</p>
            <div class="contacto-datos">
                <div class="dato-item">
                    <span class="dato-icono">📧</span>
                    <span>Finedu@gmail.com</span>
                </div>
                <div class="dato-item">
                    <span class="dato-icono">📍</span>
                    <span>Medellin, Colombia</span>
                </div>
                <div class="dato-item">
                    <span class="dato-icono">📱</span>
                    <span>555 555 5555</span>
                </div>
            </div>
        </div>
        <div class="contacto-formulario" id="contacto-formulario">
            <form method="POST" action="#">
                @csrf
                <div class="campo-grupo">
                    <div class="campo">
                        <label for="f-nombre">Nombre <span class="campo-requerido">*</span></label>
                        <input type="text" id="f-nombre" name="nombre"
                               placeholder="Tu nombre completo"
                               minlength="2" maxlength="80" autocomplete="name" required>
                    </div>
                    <div class="campo">
                        <label for="f-correo">Correo electrónico <span class="campo-requerido">*</span></label>
                        <input type="email" id="f-correo" name="correo"
                               placeholder="tu@correo.com" autocomplete="email" required>
                    </div>
                </div>
                <div class="campo">
                    <label for="f-telefono">Teléfono <span class="campo-opcional">(opcional)</span></label>
                    <input type="tel" id="f-telefono" name="telefono"
                           placeholder="300 123 4567"
                           pattern="[0-9\s\+\-]{7,15}" autocomplete="tel">
                </div>
                <div class="campo">
                    <label for="f-asunto">Asunto <span class="campo-requerido">*</span></label>
                    <input type="text" id="f-asunto" name="asunto"
                           placeholder="¿En qué podemos ayudarte?"
                           minlength="3" maxlength="120" required>
                </div>
                <div class="campo">
                    <label for="f-mensaje">Mensaje <span class="campo-requerido">*</span></label>
                    <textarea id="f-mensaje" name="mensaje"
                              placeholder="Cuéntanos tu consulta o comentario..."
                              rows="5" minlength="10" maxlength="1000" required></textarea>
                </div>
                <p class="leyenda-requerido"><span class="campo-requerido">*</span> Campos obligatorios</p>
                <button class="btn-enviar" type="submit">Enviar mensaje</button>
            </form>
        </div>
    </div>
</section>