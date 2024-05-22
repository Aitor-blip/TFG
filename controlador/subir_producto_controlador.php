<?php
session_start();
require_once '../config/conexion.php'; // Ajusta la ruta al archivo de conexión

// Verificar si el usuario está autenticado y es vendedor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendedor') {
    header("Location: ../vista/login.php");
    exit();
}

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['nombreProducto'];
    $talla = $_POST['talla'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $condicion = $_POST['condicion'];
    $idCategoria = $_POST['idCategoria'];
    $idUsuario = $_SESSION['user_id'];
    $foto = $_FILES['foto']['name'];

    // Ruta de la carpeta de destino
    $target_dir = "../assets/uploads/";

    // Verificar si la carpeta de destino existe, si no, crearla
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Ruta completa del archivo
    $target_file = $target_dir . basename($foto);

    // Mover el archivo subido a la carpeta de destino
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        // Establecer la conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();

        try {
            // Insertar producto en la base de datos
            $query = "INSERT INTO Productos (nombreProducto, talla, descripcion, precio, condicion, foto, idUsuario, idCategoria) 
                      VALUES (:nombreProducto, :talla, :descripcion, :precio, :condicion, :foto, :idUsuario, :idCategoria)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombreProducto', $nombreProducto);
            $stmt->bindParam(':talla', $talla);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':condicion', $condicion);
            $stmt->bindParam(':foto', $target_file);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idCategoria', $idCategoria);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Producto subido con éxito.";
            } else {
                $_SESSION['error'] = "Error al insertar el producto en la base de datos: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Error al subir la foto del producto.";
    }

    header("Location: ../vista/miperfil.php");
    exit();
} else {
    header("Location: ../vista/subir_producto.php");
    exit();
}
?>
