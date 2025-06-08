<?php
session_start();
require_once '../php/conexion.php';
$usuarios = $conn->query("SELECT * FROM usuarios")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios - Admin</title>
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
    <h1 class="titulo-seccion">Usuarios Registrados</h1>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Registro</th><th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['telefono']) ?></td>
                    <td><?= $u['fecha_registro'] ?></td>
                    <td><?= $u['tipo'] ?></td>
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
