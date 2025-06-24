<?php
session_start();
require_once '../php/conexion.php';
$categorias = $conn->query("SELECT * FROM categorias")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php include 'sidebar.php'; ?>
</head>
<body>
<header class="cabecera">
    <div class="contenedor">
        <div class="logo"><i class="fas fa-paw"></i><h1>Pet House - Admin</h1></div>
    </div>
</header>

<main class="contenedor">
    <h1 class="titulo-seccion">Gestión de Categorías</h1>

    <button class="boton" onclick="abrirModal()">+ Nueva Categoría</button>

    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Ícono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['descripcion']) ?></td>
                    <td><i class="fas <?= htmlspecialchars($c['icono']) ?>"></i></td>
                    <td>
                        <button class="boton btn-editar" data-id="<?= $c['id'] ?>" data-nombre="<?= $c['nombre'] ?>" data-descripcion="<?= $c['descripcion'] ?>" data-icono="<?= $c['icono'] ?>">Editar</button>
                        <a href="php_categoria/eliminar_categoria.php?id=<?= $c['id'] ?>" class="boton boton-secundario" onclick="return confirm('¿Seguro que deseas eliminar esta categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div id="modal-categoria" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h2 id="modal-titulo">Nueva Categoría</h2>
            <form action="php_categoria/guardar_categoria.php" method="POST" >
                <input type="hidden" name="id" id="cat-id">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="cat-nombre" required>
                
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="cat-descripcion" required></textarea>

                <label for="icono">Selecciona un ícono:</label>
                    <div class="icon-selector">
                    <?php
                    $iconos = ['fa-dog', 'fa-cat', 'fa-bone', 'fa-paw', 'fa-fish', 'fa-pills', 'fa-heart', 'fa-plus', 'fa-star', 'fa-home'];
                    foreach ($iconos as $icono): ?>
                        <span class="icon-option" data-icono="<?= $icono ?>"><i class="fas <?= $icono ?>"></i></span>
                    <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="icono" id="cat-icono" required>
                    <div id="icono-preview" style="margin-top:10px;"></div>

                <button type="submit" class="boton">Guardar</button>
            </form>
        </div>
    </div>
</main>
<script src="icono.js"></script>
<script>
function abrirModal() {
    document.getElementById('modal-categoria').style.display = 'block';
    document.getElementById('modal-titulo').textContent = 'Nueva Categoría';
    document.getElementById('cat-id').value = '';
    document.getElementById('cat-nombre').value = '';
    document.getElementById('cat-descripcion').value = '';
    document.getElementById('cat-icono').value = '';
}

function cerrarModal() {
    document.getElementById('modal-categoria').style.display = 'none';
}

document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {
        abrirModal();
        document.getElementById('modal-titulo').textContent = 'Editar Categoría';
        document.getElementById('cat-id').value = btn.dataset.id;
        document.getElementById('cat-nombre').value = btn.dataset.nombre;
        document.getElementById('cat-descripcion').value = btn.dataset.descripcion;
        document.getElementById('cat-icono').value = btn.dataset.icono;
    });
});
</script>

</body>
</html>
