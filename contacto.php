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
  <style>
    .contacto-info {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    .cuadro-info {
      flex: 1 1 250px;
      background: #f8f8f8;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .cuadro-info i {
      font-size: 1.5rem;
      color: #2e8b57;
      margin-right: 10px;
    }

    .cuadro-info p {
      margin: 0.5rem 0;
      font-size: 1rem;
    }
  </style>
</head>
<body>

<!-- CABECERA -->
<header class="cabecera">
  <div class="contenedor">
    <div class="logo">
      <i class="fas fa-paw"></i>
      <h1>Pet House</h1>
    </div>
    <nav class="navegacion">
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
    <button class="boton-menu" aria-label="Menú móvil">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>

<!-- CONTENIDO -->
<main class="contenedor">
  <h1 class="titulo-seccion">Contáctanos</h1>
  <p class="subtitulo-seccion">Aquí tienes nuestros datos de contacto</p>

  <div class="contacto-info">
    <div class="cuadro-info">
      <h3><i class="fas fa-map-marker-alt"></i> Dirección</h3>
      <p>Av. Las Mascotas 123, Cusco, Perú</p>
      <h3><i class="fas fa-phone-alt"></i> Teléfono</h3>
      <p>+51 987 654 321</p>
    </div>
    <div class="cuadro-info">
      <h3><i class="fas fa-envelope"></i> Correo Electrónico</h3>
      <p>contacto@pethouse.com</p>
      <h3><i class="fas fa-clock"></i> Horario de Atención</h3>
      <p>Lunes a Sábado: 9:00am - 6:00pm</p>
    </div>
  </div>

  <!-- Mapa -->
  <section class="mapa-seccion">
    <h2>Nuestra Ubicación</h2>
    <div id="mapa" style="height: 300px; border-radius: 10px;"></div>
  </section>
</main>

<!-- PIE DE PÁGINA -->
<footer class="pie-pagina">
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

  // Mapa
  const mapa = L.map('mapa').setView([-13.5226, -71.9673], 15); // Coordenadas de Cusco
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapa);
  L.marker([-13.5226, -71.9673]).addTo(mapa)
    .bindPopup('Pet House Veterinaria')
    .openPopup();
</script>
</body>
</html>
