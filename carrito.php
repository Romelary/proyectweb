<?php
session_start();
$usuario_logueado = isset($_SESSION['usuario']) || isset($_SESSION['usuario_id']);
include_once 'php/conexion.php';
$carrito = $_SESSION['carrito'] ?? [];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Tu carrito de compras - Pet House" />
  <title>Pet House - Carrito</title>
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
  <a href="servicios.php">Servicios</a>
  <a href="productos.php">Productos</a>
  <a href="citas.php">Citas</a>
  <a href="contacto.php">Contacto</a>
  <a href="carrito.php" class="carrito-link activo">
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
  <li><a href="contacto.php"><i class="fas fa-phone-alt"></i> Contacto</a></li>
  <li><a href="carrito.php" class="carrito-link activo"><i class="fas fa-shopping-cart"></i> <span id="contador-carrito-mobile">0</span></a></li>
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
    <h1 class="titulo-seccion">Tu Carrito</h1>

    <?php if (empty($carrito)) : ?>
      <p class="mensaje">Tu carrito está vacío 😿</p>
      <a href="productos.php" class="boton">Ir a productos</a>
    <?php else : ?>
      <table class="tabla-carrito">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($carrito as $id => $cantidad) {
            $sql = "SELECT * FROM productos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $producto = $res->fetch_assoc();

            if ($producto) {
              $nombre = htmlspecialchars($producto['nombre']);
              $precio = $producto['precio'];
              $subtotal = $precio * $cantidad;
              $total += $subtotal;
          ?>
              <tr>
                <td><?php echo $nombre; ?></td>
                <td>S/ <?php echo number_format($precio, 2); ?></td>
                <td>
                  <button class="btn-cantidad" data-producto-id="<?php echo $id; ?>" data-accion="restar">-</button>
                  <span><?php echo $cantidad; ?></span>
                  <button class="btn-cantidad" data-producto-id="<?php echo $id; ?>" data-accion="sumar">+</button>
                </td>
                <td>S/ <?php echo number_format($subtotal, 2); ?></td>
                <td>
                  <button class="btn-eliminar" data-producto-id="<?php echo $id; ?>"><i class="fas fa-trash-alt"></i></button>
                </td>
              </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>

      <div class="resumen-carrito">
        <p class="total-carrito">Total: <strong>S/ <?php echo number_format($total, 2); ?></strong></p>

        <?php if ($usuario_logueado): ?>
          <a href="pasarela/checkout.php" class="boton">Ir a pagar</a>
        <?php else: ?>
          <button class="boton" id="boton-login-modal">Ir a pagar</button>
        <?php endif; ?>

        <button id="vaciar-carrito" class="boton boton-cancelar">Vaciar carrito</button>
      </div>
    <?php endif; ?>
  </main>

  <!-- PIE DE PÁGINA -->
  <footer class="pie-pagina" aria-label="Pie de página">
    <div class="contenedor">
      <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
    </div>
  </footer>

  <!-- MODAL LOGIN REQUERIDO -->
  <div id="modal-login" class="modal-overlay" style="display: none;">
    <div class="modal-contenido">
      <h2>Iniciar Sesión</h2>
      <p>Para continuar necesitas iniciar sesión</p>
      <div class="botones-modal">
        <a href="login.php" class="boton">Iniciar sesión</a>
        <button id="cancelar-modal" class="boton cancelar">Cancelar</button>
      </div>
    </div>
  </div>

  <style>
    .modal-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.7);
      display: flex; justify-content: center; align-items: center;
      z-index: 9999;
    }
    .modal-contenido {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      text-align: center;
      max-width: 400px;
    }
    .botones-modal .boton {
      display: inline-block;
      margin: 1rem 0.5rem 0 0.5rem;
      padding: 0.5rem 1rem;
      background-color: #4CAF50;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
    .boton.cancelar {
      background-color: #888;
    }
  </style>

  <!-- SCRIPTS -->
  <script src="js/boton-menu.js"></script>
  <script src="js/carrito.js"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    const btnModal = document.getElementById('boton-login-modal');
    const modal = document.getElementById('modal-login');
    const cancelarBtn = document.getElementById('cancelar-modal');

    if (btnModal && modal) {
      btnModal.addEventListener('click', () => {
        modal.style.display = 'flex';
      });
    }
    if (cancelarBtn) {
      cancelarBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });
    }
  </script>
</body>
</html>
