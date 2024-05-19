<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/login.php');
    exit;
}

// Obtener información del usuario
$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->prepare("SELECT * FROM Usuarios WHERE idUsuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Hashear nueva contraseña si se proporciona
    $nombre = $_POST['nombre'];
    $apellidos1 = $_POST['apellidos1'];
    $apellidos2 = $_POST['apellidos2'];
    $sexo = $_POST['sexo'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $descripcion = $_POST['descripcion'];

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Actualizar usuario en la tabla Usuarios
        $sql = "UPDATE Usuarios SET nombreUsuario = ?, nombre = ?, apellidos1 = ?, apellidos2 = ?, email = ?, sexo = ?, fechaNacimiento = ?, descripcion = ?";
        $params = [$nombreUsuario, $nombre, $apellidos1, $apellidos2, $email, $sexo, $fechaNacimiento, $descripcion];

        if ($password) {
            $sql .= ", password = ?";
            $params[] = $password;
        }

        $sql .= " WHERE idUsuario = ?";
        $params[] = $userId;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        // Confirmar la transacción
        $conn->commit();

        header('Location: ../vista/miperfil.php?mensaje=Perfil actualizado con éxito.');
        exit;
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollBack();
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}
?>
