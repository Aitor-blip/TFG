<?php
require_once '../config/conexion.php';

if (admin) {
    $idUsuario = $_GET['idUsuario'];
    
    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    // Obtener el DNI cifrado
    $stmt = $conn->prepare("SELECT dni FROM ValidacionDNI WHERE idUsuario = ?");
    $stmt->execute([$idUsuario]);
    $dniCifrado = $stmt->fetchColumn();

    // Desencriptar el DNI
    $encryption_key = 'clave_secreta'; // Asegúrate de usar la misma clave secreta
    $dniCifrado = base64_decode($dniCifrado);
    $iv = substr($dniCifrado, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $dniCifrado = substr($dniCifrado, openssl_cipher_iv_length('aes-256-cbc'));
    $dniDesencriptado = openssl_decrypt($dniCifrado, 'aes-256-cbc', $encryption_key, 0, $iv);

    // Mostrar la imagen
    header("Content-type: image/jpeg");
    echo $dniDesencriptado;
} else {
    echo "Acceso denegado.";
}
?>

