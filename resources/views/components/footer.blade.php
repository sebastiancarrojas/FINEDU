{{-- ══════════════════════════════════════════
     MÓDULO 1: FOOTER PRINCIPAL
     Pie de página estático de la landing page.
     Contenido puramente visual, sin controlador
     ni base de datos. Dividido en 4 columnas:
     marca, producto, empresa y legal.
     IMPORTANTE: todos los href="#" son enlaces
     pendientes de implementar.
══════════════════════════════════════════ --}}
<footer class="footer">
  <div class="footer-container">

    {{-- ══════════════════════════════════════════
         MÓDULO 1A: COLUMNA MARCA
         Nombre de la app, descripción breve
         y enlaces a redes sociales.
         Íconos provistos por Font Awesome 6
         (debe estar cargado en el <head>).
    ══════════════════════════════════════════ --}}
    <div class="footer-brand">
      <h2>Finedu</h2>
      <p>Tu dinero bajo control. Organiza tus ingresos, gastos y ahorra de forma inteligente.</p>

      <div class="footer-link">
        <h4>Síguenos</h4>
        <div class="social-link">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>

    {{-- ══════════════════════════════════════════
         MÓDULO 1B: COLUMNA PRODUCTO
         Links hacia los módulos principales
         de la aplicación. Sin implementar aún.
    ══════════════════════════════════════════ --}}
    <div class="footer-section">
      <h3>Producto</h3>
      <a href="#">Simulador de salario</a>
      <a href="#">Control de gastos</a>
      <a href="#">Proyección de ahorro</a>
    </div>

    {{-- ══════════════════════════════════════════
         MÓDULO 1C: COLUMNA EMPRESA
         Links informativos sobre la organización.
         Sin implementar aún.
    ══════════════════════════════════════════ --}}
    <div class="footer-section">
      <h3>Empresa</h3>
      <a href="#">Sobre nosotros</a>
      <a href="#">Blog</a>
      <a href="#">Afiliados</a>
      <a href="#">Contacto</a>
    </div>

    {{-- ══════════════════════════════════════════
         MÓDULO 1D: COLUMNA LEGAL
         Links a documentos legales requeridos.
         Sin implementar aún.
    ══════════════════════════════════════════ --}}
    <div class="footer-section">
      <h3>Legal</h3>
      <a href="#">Política de privacidad</a>
      <a href="#">Términos y condiciones</a>
      <a href="#">Tratamiento de datos</a>
    </div>

  </div>

  {{-- ══════════════════════════════════════════
       MÓDULO 1E: BARRA DE COPYRIGHT
       Franja inferior con el año y nombre
       de la aplicación. Año hardcodeado: 2026.
  ══════════════════════════════════════════ --}}
  <div class="footer-bottom">
    <p>© 2026 Finedu</p>
  </div>

</footer>