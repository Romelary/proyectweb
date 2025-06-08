<?php
session_start();
require_once '../php/conexion.php';
$contactos = $conn->query("SELECT * FROM contactos ORDER BY fecha DESC")->fetch_all(MYSQLI_ASSOC);

// Marcar como leído si se envió ID
if (isset($_GET['leido'])) {
    $id = intval($_GET['leido']);
    $conn->query("UPDATE contactos SET leido = 1 WHERE id = $id");
    header("Location: contactos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes - Admin</title>
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
    <h1 class="titulo-seccion">Mensajes de Contacto</h1>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th><th>Leído</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['telefono']) ?></td>
                    <td><?= htmlspecialchars($c['asunto']) ?></td>
                    <td><?= htmlspecialchars($c['mensaje']) ?></td>
                    <td><?= $c['fecha'] ?></td>
                    <td><?= $c['leido'] ? 'Sí' : 'No' ?></td>
                    <td>
                        <?php if (!$c['leido']): ?>
                            <a href="contactos.php?leido=<?= $c['id'] ?>" class="boton">Marcar como leído</a>
                        <?php endif; ?>
                    </td>
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
