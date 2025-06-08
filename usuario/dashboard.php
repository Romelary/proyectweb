<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../php/conexion.php';
$usuario_id = $_SESSION['usuario_id'];

// Obtener citas
$citas = [];
$sqlCitas = "SELECT * FROM citas WHERE usuario_id = ? ORDER BY fecha DESC, hora DESC";
$stmt = $conn->prepare($sqlCitas);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultCitas = $stmt->get_result();
if ($resultCitas) {
    $citas = $resultCitas->fetch_all(MYSQLI_ASSOC);
}

// Obtener compras
$compras = [];
$sqlCompras = "SELECT o.*, 
                     GROUP_CONCAT(CONCAT(p.nombre, ' (x', d.cantidad, ')') SEPARATOR '<br>') AS productos
              FROM ordenes o
              JOIN orden_detalles d ON o.id = d.orden_id
              JOIN productos p ON d.producto_id = p.id
              WHERE o.usuario_id = ?
              GROUP BY o.id
              ORDER BY o.fecha DESC";
$stmt = $conn->prepare($sqlCompras);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultCompras = $stmt->get_result();
if ($resultCompras) {
    $compras = $resultCompras->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Resumen de citas y compras del usuario en Pet House">
  <title>Dashboard - Pet House</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <header class="cabecera">
    <div class="contenedor">
      <div class="logo">
        <i class="fas fa-paw"></i>
        <h1>Pet House</h1>
      </div>
      <nav class="navegacion">
        <a href="../index.php">Inicio</a>
        <a href="../servicios.php">Servicios</a>
        <a href="../productos.php">Productos</a>
        <a href="../citas.php">Citas</a>
        <a href="../contacto.php">Contacto</a>
        <a href="../carrito.php" class="carrito-link">
          <i class="fas fa-shopping-cart"></i>
          <span id="contador-carrito" class="contador-carrito">0</span>
        </a>
        <a href="dashboard.php" class="activo">Mis citas y compras</a>
        <a href="../php/cerrar.php" class="boton-login">Cerrar sesión</a>
      </nav>
      <button class="boton-menu" aria-label="Menú móvil">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <nav class="mobile-nav">
    <ul>
      <li><a href="../index.php"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="../servicios.php"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
      <li><a href="../productos.php"><i class="fas fa-pills"></i> Productos</a></li>
      <li><a href="../citas.php"><i class="fas fa-calendar-check"></i> Citas</a></li>
      <li><a href="../contacto.php"><i class="fas fa-phone-alt"></i> Contacto</a></li>
      <li><a href="../carrito.php"><i class="fas fa-shopping-cart"></i> <span class="contador-carrito" id="contador-carrito-mobile">0</span></a></li>
      <li><a href="dashboard.php"><i class="fas fa-user-check"></i> Mis citas y compras</a></li>
      <li><a href="../php/cerrar.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
    </ul>
  </nav>

  <main class="contenedor contenedor-dashboard">
    <h1 class="titulo-seccion">Hola, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h1>

    <div class="tarjeta">
      <h2>Tus Citas</h2>
      <?php if (count($citas) > 0): ?>
        <?php foreach ($citas as $cita): ?>
          <div class="item">
            <strong><?php echo $cita['nombre_mascota']; ?></strong> - <?php echo $cita['tipo_mascota']; ?><br>
            Servicio: <?php echo $cita['servicio']; ?><br>
            Fecha: <?php echo $cita['fecha']; ?> - <?php echo $cita['hora']; ?><br>
            Estado: <?php echo ucfirst($cita['estado']); ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No tienes citas registradas.</p>
      <?php endif; ?>
    </div>

    <div class="tarjeta">
      <h2>Tus Compras</h2>
      <?php if (count($compras) > 0): ?>
        <?php foreach ($compras as $compra): ?>
          <div class="item">
            <strong>Fecha:</strong> <?php echo $compra['fecha']; ?><br>
            <strong>Productos:</strong><br>
            <?php echo $compra['productos']; ?><br>
            <strong>Total:</strong> S/ <?php echo $compra['total']; ?><br>
            Estado: <?php echo ucfirst($compra['estado']); ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No has realizado compras aún.</p>
      <?php endif; ?>
    </div>
  </main>

  <footer class="pie-pagina">
    <div class="contenedor">
      <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
    </div>
  </footer>

  <script src="../js/boton-menu.js"></script>
  <script src="../js/carrito.js"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
