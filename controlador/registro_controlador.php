<?php
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreUsuario = $_POST['nombreUsuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos1 = $_POST['apellidos1'];
    $apellidos2 = $_POST['apellidos2'];
    $sexo = $_POST['sexo'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $descripcion = $_POST['descripcion'];
    $fotoPerfil = $_FILES['foto']['name'];
    $dniFoto = $_FILES['dni']['tmp_name'];

    // Subir foto de perfil
    if (!empty($fotoPerfil)) {
        $fotoTempPerfil = $_FILES['foto']['tmp_name'];
        $hashedFotoPerfil = md5_file($fotoTempPerfil);
        $rutaFotoPerfil = "../assets/img/perfil_$hashedFotoPerfil.jpg";
        move_uploaded_file($fotoTempPerfil, $rutaFotoPerfil);
    } else {
        $rutaFotoPerfil = null;
    }

    // Cifrar la imagen del DNI
    $encryption_key = 'clave_secreta'; // Cambia esto por una clave secreta segura
    $dniData = file_get_contents($dniFoto);
    $dniCifrado = openssl_encrypt($dniData, 'aes-256-cbc', $encryption_key, 0, $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')));
    $dniCifrado = base64_encode($iv . $dniCifrado);

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar usuario en la tabla Usuarios
        $stmt = $conn->prepare("INSERT INTO Usuarios (nombreUsuario, nombre, apellidos1, apellidos2, email, password, sexo, fechaNacimiento, descripcion, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombreUsuario, $nombre, $apellidos1, $apellidos2, $email, $password, $sexo, $fechaNacimiento, $descripcion, $rutaFotoPerfil]);
        $idUsuario = $conn->lastInsertId();

        // Obtener id del rol
        $stmt = $conn->prepare("SELECT idRol FROM Roles WHERE nombreRol = ?");
        $stmt->execute([$tipoUsuario]);
        $idRol = $stmt->fetchColumn();

        // Asignar rol al usuario
        $stmt = $conn->prepare("INSERT INTO Usuarios_Roles (idUsuario, idRol) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $idRol]);

        // Insertar el DNI en la tabla ValidacionDNI
        $estado = 'pendiente';
        $fechaValidacion = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO ValidacionDNI (dni, estado, idUsuario, fechaValidacion) VALUES (?, ?, ?, ?)");
        $stmt->execute([$dniCifrado, $estado, $idUsuario, $fechaValidacion]);

        // Confirmar la transacción
        $conn->commit();

        header('Location: ../vista/login.php?mensaje=Registro completado con éxito. Inicie sesión.');
        exit;
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollBack();
        echo "Error en el registro: " . $e->getMessage();
    }
}
?>
