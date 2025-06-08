<?php
session_start();
require_once '../php/conexion.php';
$productos = $conn->query("SELECT * FROM productos")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <style>
    .contenedor{
        margin-top: 50px
    }
</style>
<head>
    <meta charset="UTF-8">
    <title>Productos - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="admin.css">
   <?php include 'sidebar.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
  <style>
    .main .contenedor {
        margin-top: 100px;
        
    }
  </style>
  <!--  -->
    <!-- Botón flotante -->
<button id="btn-nuevo-producto" class="boton" style="margin-bottom: 20px;"><i class="fas fa-plus"></i> Nuevo Producto</button>

<!-- Modal -->
<div id="modal-producto" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <h2 id="modal-titulo">Nuevo Producto</h2>
    <form id="form-producto" enctype="multipart/form-data">
      <input type="hidden" name="id" id="producto-id">

      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" id="nombre" required>

      <label for="categoria_id">Categoría:</label>
      <select name="categoria_id" id="categoria_id" required>
        <option value="">Seleccionar</option>
        <option value="1">Accesorios</option>
        <option value="2">Comida</option>
        <option value="3">Medicinas</option>
      </select>

      <label for="descripcion">Descripción:</label>
      <textarea name="descripcion" id="descripcion" required></textarea>

      <label for="precio">Precio:</label>
      <input type="number" name="precio" id="precio" step="0.01" required>

      <label for="precio_anterior">Precio anterior:</label>
      <input type="number" name="precio_anterior" id="precio_anterior" step="0.01">

      <label for="stock">Stock:</label>
      <input type="number" name="stock" id="stock" required>

      <label for="destacado">¿Destacado?</label>
      <select name="destacado" id="destacado">
        <option value="0">No</option>
        <option value="1">Sí</option>
      </select>

      <label for="imagen">Imagen:</label>
      <input type="file" name="imagen" id="imagen" accept="image/*">
      <div id="preview-imagen"></div>

      <button type="submit" class="boton">Guardar</button>
    </form>
  </div>
</div>

<!--  -->
<body>
   
<header class="cabecera">
    <div class="contenedor">
        <div class="logo"><i class="fas fa-paw"></i><h1>Pet House - Admin</h1></div>
    
    </div>
</header>
  
    
<main class="contenedor">
    
    <h1 class="titulo-seccion">Gestión de Productos</h1>
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>ID</th><th>Imagen</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><img src="../<?= $p['imagen'] ?>" width="60" height="60" style="object-fit:cover;"></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['descripcion']) ?></td>
                    <td>S/ <?= number_format($p['precio'], 2) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <button class="boton btn-editar" data-id="<?= $p['id'] ?>"><i class="fas fa-edit"></i> Editar</button>
                        <button class="boton boton-secundario btn-eliminar" data-id="<?= $p['id'] ?>"><i class="fas fa-trash"></i> Eliminar</but>
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

<script src="admin-productos.js"></script>
<script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
