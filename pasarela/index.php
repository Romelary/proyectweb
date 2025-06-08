<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    $actual_url = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$actual_url");
    exit();
}
require_once '../php/conexion.php';       // Conexión a pet_house (productos)
require_once 'conexion.php';              // Conexión a pethouse_pagos (tarjetas y boletas)

// if (!isset($_SESSION['monto_total']) || !isset($_SESSION['carrito'])) {
//     header('Location: ../carrito.php');
//     exit;
// }

// $monto = $_SESSION['monto_total'];
// $carrito = $_SESSION['carrito'];
$carrito = [];

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("SELECT producto_id, cantidad FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $carrito[$row['producto_id']] = $row['cantidad'];
    }
} else {
    $carrito = $_SESSION['carrito'] ?? [];
}

if (empty($carrito)) {
    header('Location: ../carrito.php');
    exit;
}

$monto = 0;
foreach ($carrito as $id => $cantidad) {
    $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $producto = $res->fetch_assoc();
    if ($producto) {
        $monto += $producto['precio'] * $cantidad;
    }
}
$_SESSION['monto_total'] = $monto;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $expiracion = $_POST['expiracion'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if ($numero && $nombre && $expiracion && $cvv) {
        // Verificar si la tarjeta ya existe
        $stmt = $connPagos->prepare("SELECT id FROM tarjetas WHERE numero = ?");
        $stmt->bind_param("s", $numero);
        $stmt->execute();
        $result = $stmt->get_result();
        $tarjeta = $result->fetch_assoc();

        if (!$tarjeta) {
            // Guardar nueva tarjeta
            $stmt = $connPagos->prepare("INSERT INTO tarjetas (numero, nombre, expiracion, cvv) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $numero, $nombre, $expiracion, $cvv);
            $stmt->execute();
        }

        // Crear boleta
        $referencia = 'PET-' . strtoupper(uniqid());
        $stmt = $connPagos->prepare("INSERT INTO boletas (total, referencia) VALUES (?, ?)");
        $stmt->bind_param("ds", $monto, $referencia);
        $stmt->execute();
        $boleta_id = $connPagos->insert_id;

        // Guardar detalle de cada producto
        foreach ($carrito as $id => $cantidad) {
            $stmtProd = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
            $stmtProd->bind_param("i", $id);
            $stmtProd->execute();
            $res = $stmtProd->get_result();
            $producto = $res->fetch_assoc();

            if ($producto) {
                $nombreProd = $producto['nombre'];
                $subtotal = $producto['precio'] * $cantidad;

                $stmtDet = $connPagos->prepare("INSERT INTO boleta_detalles (boleta_id, producto_nombre, cantidad, subtotal) VALUES (?, ?, ?, ?)");
                $stmtDet->bind_param("isid", $boleta_id, $nombreProd, $cantidad, $subtotal);
                $stmtDet->execute();
            }
        }

        // Limpiar sesión de carrito y guardar boleta
        // Limpiar carrito (sesión o BD según corresponda)
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
} else {
    unset($_SESSION['carrito']);
}

$_SESSION['ultima_boleta'] = $referencia;


        header('Location: resultado.php');
        exit;
    }
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pasarela de Pagos - Pet House</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .contenedor-pago {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
      padding: 30px;
    }
    .logo-pago {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo-pago i { font-size: 50px; color: #4b6cb7; }
    .logo-pago h1 { margin: 10px 0 0; color: #333; }
    .resumen-pago {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .total-pago {
      font-size: 24px;
      font-weight: bold;
      color: #4b6cb7;
      text-align: right;
    }
    .form-pago input {
      width: 100%; padding: 10px; margin-bottom: 15px;
      border: 1px solid #ccc; border-radius: 4px;
    }
    .boton-pagar, .boton-cancelar {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 4px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .boton-pagar {
      background-color: #4b6cb7;
    }
    .boton-pagar:hover {
      background-color: #3a5a9d;
    }
    .boton-cancelar {
      background-color: #aaa;
    }
    .boton-cancelar:hover {
      background-color: #888;
    }
  </style>
</head>
<body>
  <div class="contenedor-pago">
    <div class="logo-pago">
      <i class="fas fa-paw"></i>
      <h1>Pet House</h1>
    </div>

    <div class="resumen-pago">
      <h2>Resumen de Pago</h2>
      <p>Estás a punto de pagar:</p>
      <div class="total-pago">S/. <?= number_format($monto, 2) ?></div>
    </div>

    <form method="POST" class="form-pago">
      <input type="text" name="numero" placeholder="Número de tarjeta" required>
      <input type="text" name="nombre" placeholder="Nombre en la tarjeta" required>
      <input type="text" name="expiracion" placeholder="MM/AA" required>
      <input type="text" name="cvv" placeholder="CVV" required>

      <button type="submit" class="boton-pagar">
        <i class="fas fa-lock"></i> Confirmar y Pagar
      </button>
    </form>

    <form action="../carrito.php">
      <button type="submit" class="boton-cancelar">Cancelar y volver</button>
    </form>
  </div>
</body>
</html>
