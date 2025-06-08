<?php
// productos.php
include 'php/conexion.php'; // Archivo con la conexión a la base de datos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener productos de la base de datos
$conexion = new mysqli("localhost", "romel", "123456", "pet_house");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$query = "SELECT p.*, c.nombre as categoria_nombre 
          FROM productos p 
          LEFT JOIN categorias c ON p.categoria_id = c.id";

$resultado = $conexion->query($query);

if ($resultado) {
    $productos = $resultado->fetch_all(MYSQLI_ASSOC);
    // Ahora puedes usar $productos
} else {
    echo "Error en la consulta: " . $conexion->error;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Productos para mascotas en Pet House - Alimentos, medicamentos y accesorios de calidad">
    <title>Pet House - Productos para Mascotas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <div class="logo">
                <i class="fas fa-paw"></i>
                <h1>Pet House</h1>
            </div>
            <nav class="navegacion">
                <a href="index.html">Inicio</a>
                <a href="servicios.html">Servicios</a>
                <a href="productos.php" class="activo">Productos</a>
                <a href="citas.php">Citas</a>
                <a href="contacto.html">Contacto</a>
                <a href="carrito.php" class="carrito-link">
                  <i class="fas fa-shopping-cart"></i>
                  <span id="contador-carrito" class="contador-carrito">0</span>
                </a>
                <a href="login.php" class="boton-login">Ingresar</a>
            </nav>
            <button class="boton-menu" aria-label="Menú móvil">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <nav class="mobile-nav">
        <ul>
            <li><a href="index.html"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="servicios.html"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
            <li><a href="productos.php" class="activo"><i class="fas fa-pills"></i> Productos</a></li>
            <li><a href="citas.php"><i class="fas fa-calendar-check"></i> Citas</a></li>
            <li><a href="contacto.html"><i class="fas fa-phone-alt"></i> Contacto</a></li>
             <li><a href="carrito.php" class="carrito-link"><i class="fas fa-shopping-cart"></i> <span class="contador-carrito" id="contador-carrito-mobile">0</span></a></li>
            <li><a href="login.php"><i class="fas fa-user"></i> Login</a></li>
        </ul>
    </nav>

    <main class="contenedor">
        <h1 class="titulo-seccion">Nuestros Productos</h1>
        <p class="subtitulo-seccion">Calidad y variedad para el cuidado de tu mascota</p>
        
        <div class="filtros">
            <button class="boton-filtro activo" data-categoria="todos">Todos</button>
            <button class="boton-filtro" data-categoria="alimentos">Alimentos</button>
            <button class="boton-filtro" data-categoria="medicamentos">Medicamentos</button>
            <button class="boton-filtro" data-categoria="accesorios">Accesorios</button>
        </div>
        
        <div class="lista-productos">
            <?php foreach($productos as $producto): 
                $categoria = strtolower($producto['categoria_nombre']);
                $precio_anterior = $producto['precio_anterior'] > 0 ? 
                    '<p class="producto-precio-anterior">S/.' . number_format($producto['precio_anterior'], 2) . '</p>' : '';
            ?>
            <article class="producto" data-categoria="<?= $categoria ?>">
                <div class="producto-imagen-container">
                    <img src="<?= $producto['imagen'] ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="producto-imagen">
                    <span class="producto-etiqueta"><?= $producto['categoria_nombre'] ?></span>
                    <?php if($producto['destacado']): ?>
                        <span class="producto-destacado">Destacado</span>
                    <?php endif; ?>
                </div>
                <div class="producto-info">
                    <h2 class="producto-titulo"><?= htmlspecialchars($producto['nombre']) ?></h2>
                    <p class="producto-descripcion"><?= htmlspecialchars($producto['descripcion']) ?></p>
                    <div class="producto-precio-container">
                        <p class="producto-precio">S/.<?= number_format($producto['precio'], 2) ?></p>
                        <?= $precio_anterior ?>
                    </div>
                    <div class="producto-stock">
                        <?php if($producto['stock'] > 0): ?>
                            <span class="stock-disponible">Disponible: <?= $producto['stock'] ?></span>
                        <?php else: ?>
                            <span class="stock-agotado">Agotado</span>
                        <?php endif; ?>
                    </div>
                    <div class="producto-acciones">
                        <button class="boton boton-producto" 
                                data-producto-id="<?= $producto['id'] ?>"
                                <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                            <i class="fas fa-shopping-cart"></i> Añadir al carrito
                        </button>
                        <button class="boton-favorito" 
                                aria-label="Añadir a favoritos"
                                data-producto-id="<?= $producto['id'] ?>">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="pie-pagina">
        <div class="contenedor">
            <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="js/boton-menu.js"></script>
    <script src="js/filtros-productos.js"></script>
    <script src="js/carrito.js"></script>
    <script>
        // Actualizar año automáticamente
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>
</html>