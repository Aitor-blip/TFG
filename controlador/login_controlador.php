<?php
session_start();
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT Usuarios.idUsuario, Usuarios.nombreUsuario, Usuarios.password, Usuarios.fechaBaja, Roles.nombreRol 
              FROM Usuarios 
              JOIN Usuarios_Roles ON Usuarios.idUsuario = Usuarios_Roles.idUsuario 
              JOIN Roles ON Usuarios_Roles.idRol = Roles.idRol 
              WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si el usuario está dado de baja
        if (!is_null($row['fechaBaja'])) {
            $error = "Tu cuenta ha sido dada de baja. Por favor, regístrate nuevamente.";
            header("Location: ../vista/login.php?error=" . urlencode($error));
            exit();
        }
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['idUsuario'];
            $_SESSION['username'] = $row['nombreUsuario'];
            $_SESSION['role'] = $row['nombreRol'];
            
            switch ($row['nombreRol']) {
                case 'admin':
                    header("Location: ../vista/principal_admin.php");
                    break;
                case 'vendedor':
                    header("Location: ../vista/principal.php");
                    break;
                case 'comprador':
                    header("Location: ../vista/principal.php");
                    break;
                case 'invitado':
                    header("Location: /vista/principal.php");
                    break;
                default:
                    $error = "Tipo de usuario no reconocido.";
                    header("Location: ../vista/login.php?error=" . urlencode($error));
                    break;
            }
            exit();
        } else {
            $error = "Correo electrónico o contraseña incorrectos.";
            header("Location: ../vista/login.php?error=" . urlencode($error));
        }
    } else {
        $error = "Correo electrónico o contraseña incorrectos.";
        header("Location: ../vista/login.php?error=" . urlencode($error));
    }
}
?>
