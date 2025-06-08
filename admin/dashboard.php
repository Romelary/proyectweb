<?php
session_start();
require_once '../php/conexion.php';

// Contar registros
$usuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc();
$citas = $conn->query("SELECT COUNT(*) AS total FROM citas")->fetch_assoc();
$contactos = $conn->query("SELECT COUNT(*) AS total FROM contactos")->fetch_assoc();
$productos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Pet House Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="admin.css">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header class="cabecera">
    <div class="contenedor">
        <div class="logo"><i class="fas fa-paw"></i><h1>Pet House - Admin</h1></div>
        <nav class="navegacion">
            <a href="../index.html">Inicio</a>
            <a href="../php/cerrar.php" class="activo">Cerrar sesion</a>
        </nav>
    </div>
</header>

<main class="contenedor">
    <h1 class="titulo-seccion">Dashboard de Administración</h1>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <h3>Productos</h3>
                <p><?= $productos['total'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <h3>Citas</h3>
                <p><?= $citas['total'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>Usuarios</h3>
                <p><?= $usuarios['total'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <h3>Mensajes</h3>
                <p><?= $contactos['total'] ?></p>
            </div>
        </div>
    </div>

    <nav class="admin-menu">
        <a href="productos.php" class="boton">Gestionar Productos</a>
        <a href="citas.php" class="boton">Ver Citas</a>
        <a href="usuarios.php" class="boton">Usuarios</a>
        <a href="contactos.php" class="boton">Mensajes</a>
    </nav>
    <footer class="pie-pagina">
    <div class="contenedor">
        <p>&copy; <span id="year"></span> Pet House - Admin</p>
    </div>
</footer>
</main>



<script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
