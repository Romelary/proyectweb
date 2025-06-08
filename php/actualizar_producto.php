<?php
session_start();
require_once 'conexion.php';
header('Content-Type: application/json');


$id = $_POST['id'];
$nombre = $_POST['nombre'];
$categoria_id = $_POST['categoria_id'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$precio_anterior = $_POST['precio_anterior'];
$stock = $_POST['stock'];
$destacado = $_POST['destacado'];

// Obtener imagen actual si no se sube una nueva
$res = $conn->query("SELECT imagen FROM productos WHERE id = $id");
$producto = $res->fetch_assoc();
$imagenRuta = $producto['imagen'];

// Si hay imagen nueva, subirla
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
    $directorioDestino = "../img/";
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0755, true);
    }
    $rutaCompleta = $directorioDestino . $nombreArchivo;
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
        $imagenRuta = "img/" . $nombreArchivo;
    }
}

$stmt = $conn->prepare("UPDATE productos SET nombre=?, categoria_id=?, descripcion=?, precio=?, precio_anterior=?, stock=?, destacado=?, imagen=? WHERE id=?");
$stmt->bind_param("sisddiisi", $nombre, $categoria_id, $descripcion, $precio, $precio_anterior, $stock, $destacado, $imagenRuta, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
