<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
    require_once '../config/conexion.php';

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        // Obtener ID del usuario
        $userId = $_SESSION['user_id'];

        // Establecer la fecha de baja
        $fechaBaja = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE Usuarios SET fechaBaja = ? WHERE idUsuario = ?");
        $stmt->execute([$fechaBaja, $userId]);

        // Confirmar transacción
        $conn->commit();

        // Cerrar sesión
        session_destroy();

        // Redirigir al inicio de sesión
        header('Location: ../vista/login.php?mensaje=Perfil dado de baja exitosamente.');
        exit();
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollBack();
        echo "Error al dar de baja el perfil: " . $e->getMessage();
    }
}
?>