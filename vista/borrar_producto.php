<?php
session_start();
require_once '../config/conexion.php'; // Ajusta la ruta al archivo de conexión

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendedor') {
    header("Location: ../vista/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $idUsuario = $_SESSION['user_id'];

    $database = new Database();
    $db = $database->getConnection();

    try {
        // Eliminar producto de la base de datos
        $query = "DELETE FROM Productos WHERE idProducto = :idProducto AND idUsuario = :idUsuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->bindParam(':idUsuario', $idUsuario);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Producto borrado con éxito.";
        } else {
            $_SESSION['error'] = "Error al borrar el producto.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: ../vista/perfil.php");
    exit();
} else {
    header("Location: ../vista/perfil.php");
    exit();
}
?>
