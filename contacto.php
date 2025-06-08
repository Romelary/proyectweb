<?php
session_start();
$usuario_logueado = isset($_SESSION['usuario']) || isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Contáctanos - Veterinaria Pet House" />
  <title>Pet House - Contacto</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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
  <a href="servicios.php">Servicios</a>
  <a href="productos.php">Productos</a>
  <a href="citas.php">Citas</a>
  <a href="contacto.php" class="activo">Contacto</a>
  <a href="carrito.php" class="carrito-link">
    <i class="fas fa-shopping-cart"></i>
    <span id="contador-carrito" class="contador-carrito">0</span>
  </a>
  <?php if ($usuario_logueado): ?>
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
  <li><a href="servicios.php"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
  <li><a href="productos.php"><i class="fas fa-pills"></i> Productos</a></li>
  <li><a href="citas.php"><i class="fas fa-calendar-check"></i> Citas</a></li>
  <li><a href="contacto.php" class="activo"><i class="fas fa-phone-alt"></i> Contacto</a></li>
  <li><a href="carrito.php" class="carrito-link"><i class="fas fa-shopping-cart"></i> <span id="contador-carrito-mobile">0</span></a></li>
  <?php if ($usuario_logueado): ?>
    <li><a href="usuario/dashboard.php"><i class="fas fa-user-check"></i> Mis citas y compras</a></li>
    <li><a href="php/cerrar.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
  <?php else: ?>
    <li><a href="login.php"><i class="fas fa-user"></i> Login</a></li>
  <?php endif; ?>
</ul>
  </nav>


  <!-- CONTENIDO PRINCIPAL -->
  <main class="contenedor">
    <h1 class="titulo-seccion">Contáctanos</h1>
    <p class="subtitulo-seccion">¿Tienes dudas o necesitas ayuda? Envíanos un mensaje</p>

    <form action="mailto:tuemail@pethouse.com" method="POST" enctype="text/plain" class="formulario-contacto">
      <div class="campo">
        <label for="nombre">Nombre completo:</label>
        <input type="text" name="nombre" id="nombre" required />
      </div>

      <div class="campo">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required />
      </div>

      <div class="campo">
        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" required />
      </div>

      <div class="campo">
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" rows="5" required></textarea>
      </div>

      <input type="submit" value="Enviar mensaje" class="boton" />
    </form>

    <!-- Mapa -->
    <section class="mapa-seccion">
      <h2>Nuestra ubicación</h2>
      <div id="mapa" style="height: 300px; border-radius: 10px;"></div>
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
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="js/carrito.js"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    // Mapa con Leaflet.js
    const mapa = L.map('mapa').setView([-12.0464, -77.0428], 15); // Cambia coordenadas a las de tu veterinaria
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);
    L.marker([-12.0464, -77.0428]).addTo(mapa)
      .bindPopup('Pet House Veterinaria')
      .openPopup();
  </script>
</body>
</html>
