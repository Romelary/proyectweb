<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Veterinaria Pet House - Cuidado profesional para tus mascotas" />
  <title>Pet House - Inicio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body id="pagina-inicio">
  <!-- CABECERA -->
  <header class="cabecera" aria-label="Cabecera principal">
    <div class="contenedor">
      <div class="logo">
        <i class="fas fa-paw"></i>
        <h1>Pet House</h1>
      </div>
      <nav class="navegacion" aria-label="Navegación principal">
        <a href="index.php" class="activo">Inicio</a>
        <a href="servicios.php">Servicios</a>
        <a href="productos.php">Productos</a>
        <a href="citas.php">Citas</a>
        <a href="contacto.php">Contacto</a>
        <a href="carrito.php" class="icono-carrito">
          <i class="fas fa-shopping-cart"></i>
          <span id="contador-carrito" class="contador-carrito" style="display: none;">0</span>
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
      <li><a href="index.php" class="activo"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="servicios.php"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
      <li><a href="productos.php"><i class="fas fa-pills"></i> Productos</a></li>
      <li><a href="citas.php"><i class="fas fa-calendar-check"></i> Citas</a></li>
      <li><a href="contacto.php"><i class="fas fa-phone-alt"></i> Contacto</a></li>
      <li><a href="carrito.php" class="carrito-link"><i class="fas fa-shopping-cart"></i> <span class="contador-carrito" id="contador-carrito-mobile">0</span></a></li>
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
    <!-- Carrusel -->
    <section class="carrusel">
      <div class="carrusel-contenedor">
        <div class="carrusel-slide activo">
          <img src="img/perro.jpg" alt="Mascota feliz en nuestra clínica" />
          <div class="carrusel-texto">
            <h2>Cuidado profesional</h2>
            <p>Tu mascota en las mejores manos</p>
          </div>
        </div>
        <div class="carrusel-slide">
          <img src="img/medicmanetopet.jpg" alt="Servicios de veterinaria" />
          <div class="carrusel-texto">
            <h2>Servicios completos</h2>
            <p>Desde consultas hasta cirugías</p>
          </div>
        </div>
        <div class="carrusel-slide">
          <img src="img/imagescomida.jpg" alt="Productos de calidad" />
          <div class="carrusel-texto">
            <h2>Productos premium</h2>
            <p>Lo mejor para su salud</p>
          </div>
        </div>
      </div>
      <button class="carrusel-btn carrusel-btn-izq" aria-label="Imagen anterior">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="carrusel-btn carrusel-btn-der" aria-label="Imagen siguiente">
        <i class="fas fa-chevron-right"></i>
      </button>
      <div class="carrusel-indicadores"></div>
    </section>

    <!-- Presentación -->
    <section class="present">
      <h2>Cuidado profesional para tus mascotas</h2>
      <p>Amor y dedicación en cada consulta</p>
      <a href="citas.php" class="boton">Agendar cita</a>
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
  <script src="js/carrusel.js"></script>
  <script src="js/carrito.js"></script>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
