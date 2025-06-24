<?php
session_start();
require_once '../php/conexion.php';
$citas = $conn->query("SELECT * FROM citas ORDER BY fecha DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="admin.css">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
<header class="cabecera">
    <div class="contenedor">
        <div class="logo"><i class="fas fa-paw"></i><h1>Pet House - Admin</h1></div>
        
    </div>
</header>

<main class="contenedor">
    <h1 class="titulo-seccion">Citas Agendadas</h1>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th><th>Cliente</th><th>Mascota</th><th>Tipo</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Comentarios</th><th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['usuario_id'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($c['nombre_mascota']) ?></td>
                    <td><?= htmlspecialchars($c['tipo_mascota']) ?></td>
                    <td><?= htmlspecialchars($c['servicio']) ?></td>
                    <td><?= $c['fecha'] ?></td>
                    <td><?= $c['hora'] ?></td>
                    <td><?= htmlspecialchars($c['comentarios']) ?></td>
                    <td><?= $c['estado'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <footer class="pie-pagina">
    <div class="contenedor">
        <p>&copy; <span id="year"></span> Pet House - Admin</p>
    </div>
</footer>
</main>


<script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
