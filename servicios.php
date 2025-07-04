<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Servicios veterinarios profesionales en Pet House - Cuidado integral para tus mascotas" />
  <title>Pet House - Servicios Veterinarios</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <!-- CABECERA -->
  <header class="cabecera" aria-label="Cabecera principal">
    <div class="contenedor">
      <div class="logo">
        <i class="fas fa-paw"></i>
        <h1>Pet House</h1>
      </div>
      <nav class="navegacion" aria-label="Navegación principal">
        <a href="index.php">Inicio</a>
        <a href="servicios.php" class="activo">Servicios</a>
        <a href="productos.php">Productos</a>
        <a href="citas.php">Citas</a>
        <a href="contacto.php">Contacto</a>
        <a href="carrito.php" class="carrito-link">
          <i class="fas fa-shopping-cart"></i>
          <span id="contador-carrito" class="contador-carrito">0</span>
        </a>
        <?php if (isset($_SESSION['usuario_id'])): ?>
          <a href="usuario/dashboard.php">Mis citas y compras</a>
          <a href="php/cerrar.php" class="boton-login">Cerrar sesión</a>
        <?php else: ?>
          <a href="login.php" class="boton-login">Ingresar</a>
        <?php endif; ?>
      </nav>
      <button class="boton-menu" aria-label="Menú móvil" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <!-- MENÚ MÓVIL -->
  <nav class="mobile-nav" aria-label="Navegación móvil">
    <ul>
      <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="servicios.php" class="activo"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
      <li><a href="productos.php"><i class="fas fa-pills"></i> Productos</a></li>
      <li><a href="citas.php"><i class="fas fa-calendar-check"></i> Citas</a></li>
      <li><a href="contacto.php"><i class="fas fa-phone-alt"></i> Contacto</a></li>
      <li><a href="carrito.php"><i class="fas fa-shopping-cart"></i> <span class="contador-carrito" id="contador-carrito-mobile">0</span></a></li>
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <li><a href="usuario/dashboard.php"><i class="fas fa-user-check"></i> Mis citas y compras</a></li>
        <li><a href="php/cerrar.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login.php"><i class="fas fa-user"></i> Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="contenedor">
    <h1 class="titulo-seccion">Nuestros Servicios Veterinarios</h1>
    <p class="subtitulo-seccion">Cuidado especializado para la salud y bienestar de tu mascota</p>

    <div class="lista-servicios">
      <!-- Servicio 1 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-stethoscope"></i>
        </div>
        <h2>Consulta General</h2>
        <p>Revisión completa para diagnóstico y prevención de enfermedades.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Examen físico completo</li>
          <li><i class="fas fa-check"></i> Diagnóstico inicial</li>
          <li><i class="fas fa-check"></i> Plan de prevención</li>
        </ul>
        <a href="citas.php?servicio=consulta-general" class="boton boton-servicio">Agendar Consulta</a>
      </article>

      <!-- Servicio 2 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-syringe"></i>
        </div>
        <h2>Vacunación</h2>
        <p>Vacunas esenciales para la salud preventiva de tu mascota.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Vacunas básicas</li>
          <li><i class="fas fa-check"></i> Refuerzos anuales</li>
          <li><i class="fas fa-check"></i> Carnet de vacunación</li>
        </ul>
        <a href="citas.php?servicio=vacunacion" class="boton boton-servicio">Agendar Vacunación</a>
      </article>

      <!-- Servicio 3 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-cut"></i>
        </div>
        <h2>Estética Canina</h2>
        <p>Baño, corte y cuidado estético profesional.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Baño terapéutico</li>
          <li><i class="fas fa-check"></i> Corte de pelo</li>
          <li><i class="fas fa-check"></i> Cuidado de uñas</li>
        </ul>
        <a href="citas.php?servicio=estetica" class="boton boton-servicio">Agendar Estética</a>
      </article>

      <!-- Servicio 4 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-bone"></i>
        </div>
        <h2>Cirugías</h2>
        <p>Procedimientos quirúrgicos con equipo especializado.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Esterilización</li>
          <li><i class="fas fa-check"></i> Cirugías menores</li>
          <li><i class="fas fa-check"></i> Postoperatorio</li>
        </ul>
        <a href="citas.php?servicio=cirugia" class="boton boton-servicio">Consultar Cirugía</a>
      </article>

      <!-- Servicio 5 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-teeth"></i>
        </div>
        <h2>Odontología</h2>
        <p>Cuidado dental para prevenir enfermedades bucales.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Limpieza dental</li>
          <li><i class="fas fa-check"></i> Extracciones</li>
          <li><i class="fas fa-check"></i> Ortodoncia canina</li>
        </ul>
        <a href="citas.php?servicio=odontologia" class="boton boton-servicio">Agendar Dental</a>
      </article>

      <!-- Servicio 6 -->
      <article class="servicio">
        <div class="servicio-icono">
          <i class="fas fa-procedures"></i>
        </div>
        <h2>Hospitalización</h2>
        <p>Atención constante en casos críticos o postoperatorios.</p>
        <ul class="servicio-lista">
          <li><i class="fas fa-check"></i> Monitoreo constante</li>
          <li><i class="fas fa-check"></i> Medicación controlada</li>
          <li><i class="fas fa-check"></i> Áreas especializadas</li>
        </ul>
        <a href="citas.php?servicio=hospitalizacion" class="boton boton-servicio">Emergencias</a>
      </article>
    </div>

    <!-- Beneficios -->
    <section class="info-adicional">
      <h2>¿Por qué elegir nuestros servicios?</h2>
      <div class="ventajas">
        <div class="ventaja">
          <i class="fas fa-user-md"></i>
          <h3>Veterinarios certificados</h3>
          <p>Profesionales con experiencia comprobada.</p>
        </div>
        <div class="ventaja">
          <i class="fas fa-clinic-medical"></i>
          <h3>Instalaciones modernas</h3>
          <p>Equipamiento avanzado para mejores resultados.</p>
        </div>
        <div class="ventaja">
          <i class="fas fa-heart"></i>
          <h3>Trato amoroso</h3>
          <p>Atención con cariño y respeto a cada mascota.</p>
        </div>
      </div>
    </section>
  </main>

  <!-- PIE DE PÁGINA -->
  <footer class="pie-pagina" aria-label="Pie de página">
    <div class="contenedor">
      <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="js/boton-menu.js"></script>
  <script src="js/carrito.js"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
