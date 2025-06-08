<?php
// migrate_products.php
require_once 'php/conexion.php';

$productos = [
    [
        'nombre' => 'Alimento Premium',
        'categoria' => 'alimentos',
        'descripcion' => 'Nutrición balanceada para todas las etapas de tu perro',
        'precio' => 25.99,
        'precio_anterior' => 30.99,
        'stock' => 50,
        'imagen' => 'img/imagescomida.jpg'
    ],
    [
        'nombre' => 'Antiparasitario',
        'categoria' => 'medicamentos',
        'descripcion' => 'Protección completa contra parásitos internos y externos',
        'precio' => 18.50,
        'precio_anterior' => 0,
        'stock' => 30,
        'imagen' => 'img/medicmanetopet.jpg'
    ],
    [
        'nombre' => 'Juguete Sorpresa',
        'categoria' => 'accesorios',
        'descripcion' => 'Divertido juguete interactivo para horas de diversión',
        'precio' => 100.50,
        'precio_anterior' => 120.00,
        'stock' => 20,
        'imagen' => 'img/accesorios.webp'
    ],
    [
        'nombre' => 'Alimento para Gatos',
        'categoria' => 'alimentos',
        'descripcion' => 'Nutrición especializada para gatos adultos',
        'precio' => 22.99,
        'precio_anterior' => 0,
        'stock' => 40,
        'imagen' => 'img/alimento-gato.jpg'
    ],
    [
        'nombre' => 'Vitaminas Complejas',
        'categoria' => 'medicamentos',
        'descripcion' => 'Suplemento vitamínico para fortalecer el sistema inmunológico',
        'precio' => 35.75,
        'precio_anterior' => 0,
        'stock' => 25,
        'imagen' => 'img/vitaminas.jpg'
    ]
];

try {
    // Iniciar transacción
    $conexion->beginTransaction();

    foreach ($productos as $producto) {
        // Obtener ID de categoría
        $query = "SELECT id FROM categorias WHERE nombre = ?";
        $stmt = $conexion->prepare($query);
        $categoria = ucfirst($producto['categoria']);
        $stmt->execute([$categoria]);
        $categoria_id = $stmt->fetchColumn();

        if (!$categoria_id) {
            throw new Exception("Categoría no encontrada: " . $categoria);
        }

        // Insertar producto
        $query = "INSERT INTO productos (nombre, categoria_id, descripcion, precio, precio_anterior, stock, imagen) 
                  VALUES (:nombre, :categoria_id, :descripcion, :precio, :precio_anterior, :stock, :imagen)";
        $stmt = $conexion->prepare($query);
        
        $stmt->execute([
            ':nombre' => $producto['nombre'],
            ':categoria_id' => $categoria_id,
            ':descripcion' => $producto['descripcion'],
            ':precio' => $producto['precio'],
            ':precio_anterior' => $producto['precio_anterior'],
            ':stock' => $producto['stock'],
            ':imagen' => $producto['imagen']
        ]);
    }

    // Confirmar transacción
    $conexion->commit();
    echo "Productos migrados correctamente. " . count($productos) . " productos insertados.";
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conexion->rollBack();
    echo "Error al migrar productos: " . $e->getMessage();
}