<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
include_once '../php/conexion.php';

$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
  header('Location: ../carrito.php');
  exit;
}

$total = 0;
$detalles = [];
foreach ($carrito as $id => $cantidad) {
  $sql = "SELECT nombre, precio FROM productos WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $producto = $res->fetch_assoc();
  if ($producto) {
    $subtotal = $producto['precio'] * $cantidad;
    $total += $subtotal;
    $detalles[] = [
      'nombre' => $producto['nombre'],
      'cantidad' => $cantidad,
      'subtotal' => $subtotal
    ];
  }
}
$_SESSION['monto_total'] = $total;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmar Pedido - Pet House</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <header class="cabecera">
    <div class="contenedor">
      <div class="logo"><i class="fas fa-paw"></i><h1>Pet House</h1></div>
      <nav class="navegacion">
        <a href="../index.html">Inicio</a>
        <a href="../productos.php">Productos</a>
        <a href="../carrito.php">Carrito</a>
      </nav>
    </div>
  </header>

  <main class="contenedor">
    <h1 class="titulo-seccion">Resumen de Pedido</h1>
    <table class="tabla-carrito">
      <thead><tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th></tr></thead>
      <tbody>
        <?php foreach ($detalles as $item): ?>
          <tr>
            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
            <td><?php echo $item['cantidad']; ?></td>
            <td>S/ <?php echo number_format($item['subtotal'], 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p class="total-carrito">Total a pagar: <strong>S/ <?php echo number_format($total, 2); ?></strong></p>

    <form action="index.php" method="POST" class="formulario-pago">
      <div class="campo">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>
      <div class="campo">
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" required>
      </div>
      <div class="campo">
        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo" required>
      </div>
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <button type="submit" class="boton">Confirmar Pago</button>
      <a href="../index.html" class="boton boton-secundario">Cancelar Pago</a>      
    </form>
  </main>

  <footer class="pie-pagina">
    <div class="contenedor">
      <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
    </div>
  </footer>
  <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
