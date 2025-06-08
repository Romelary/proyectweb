<?php
session_start();
require_once 'conexion.php'; // conexión a pethouse_pagos

$referencia = $_SESSION['ultima_boleta'] ?? null;

if (!$referencia) {
    echo "<p>No hay una compra reciente registrada.</p>";
    exit;
}

// Obtener boleta
$stmt = $connPagos->prepare("SELECT id, total, fecha FROM boletas WHERE referencia = ?");
$stmt->bind_param("s", $referencia);
$stmt->execute();
$res = $stmt->get_result();
$boleta = $res->fetch_assoc();

if (!$boleta) {
    echo "<p>Boleta no encontrada.</p>";
    exit;
}

// Obtener detalles
$stmt = $connPagos->prepare("SELECT producto_nombre, cantidad, subtotal FROM boleta_detalles WHERE boleta_id = ?");
$stmt->bind_param("i", $boleta['id']);
$stmt->execute();
$detalles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Limpiar sesión
unset($_SESSION['monto_total']);
unset($_SESSION['ultima_boleta']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Boleta de Pago - Pet House</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }
    .contenedor {
      max-width: 700px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #4b6cb7;
    }
    .boleta-info {
      margin-top: 20px;
    }
    .boleta-info p {
      font-size: 16px;
      margin: 5px 0;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    table th, table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    table th {
      background-color: #4b6cb7;
      color: white;
    }
    .total {
      text-align: right;
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }
    .volver {
      display: block;
      margin: 30px auto 0;
      padding: 12px 20px;
      background-color: #4b6cb7;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
      width: fit-content;
    }
    .volver:hover {
      background-color: #3a5a9d;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h1><i class="fas fa-receipt"></i> Boleta de Pago</h1>

    <div class="boleta-info">
      <p><strong>Referencia:</strong> <?= htmlspecialchars($referencia) ?></p>
      <p><strong>Fecha:</strong> <?= htmlspecialchars($boleta['fecha']) ?></p>
    </div>

    <table>
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Subtotal (S/)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detalles as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['producto_nombre']) ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td><?= number_format($item['subtotal'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p class="total">Total pagado: S/. <?= number_format($boleta['total'], 2) ?></p>

    <a class="volver" href="../index.html"><i class="fas fa-home"></i> Volver al inicio</a>
  </div>
</body>
</html>
