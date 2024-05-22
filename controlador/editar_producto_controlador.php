<?php
session_start();
require_once '../config/conexion.php'; // Ajusta la ruta al archivo de conexión

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendedor') {
    header("Location: ../vista/login.php");
    exit();
}

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['idProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $talla = $_POST['talla'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $condicion = $_POST['condicion'];
    $idCategoria = $_POST['idCategoria'];
    $idUsuario = $_SESSION['user_id'];
    $foto = $_FILES['foto']['name'];
    $fotoActual = $_POST['fotoActual'];

    // Ruta de la carpeta de destino
    $target_dir = "../assets/uploads/";
    $target_file = $fotoActual;

    // Si se sube una nueva foto, reemplazar la foto actual
    if (!empty($foto)) {
        // Verificar si la carpeta de destino existe, si no, crearla
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    }

    // Establecer la conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    try {
        // Actualizar producto en la base de datos
        $query = "UPDATE Productos SET nombreProducto = :nombreProducto, talla = :talla, descripcion = :descripcion, precio = :precio, condicion = :condicion, foto = :foto, idCategoria = :idCategoria WHERE idProducto = :idProducto AND idUsuario = :idUsuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':talla', $talla);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':condicion', $condicion);
        $stmt->bindParam(':foto', $target_file);
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->bindParam(':idUsuario', $idUsuario);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Producto actualizado con éxito.";
        } else {
            $_SESSION['error'] = "Error al actualizar el producto.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: ../vista/miperfil.php");
    exit();
} else {
    header("Location: ../vista/miperfil.php");
    exit();
}
?>
