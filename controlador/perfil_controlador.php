<?php
require_once '../config/conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/login.php');
    exit;
}

// Conectar a la base de datos
$database = new Database();
$conn = $database->getConnection();

try {
    // Obtener información del usuario
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE idUsuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: ../vista/login.php');
        exit;
    }

    // Obtener el rol del usuario
    $stmt = $conn->prepare("SELECT R.nombreRol FROM Usuarios_Roles UR INNER JOIN Roles R ON UR.idRol = R.idRol WHERE UR.idUsuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $role = $stmt->fetchColumn();

    // Si el usuario es vendedor, obtener sus productos
    if ($role == 'vendedor') {
        $stmt = $conn->prepare("SELECT * FROM Productos WHERE idUsuario = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener valoraciones del usuario
    $stmt = $conn->prepare("SELECT AVG(valoracion) as ratingAverage, COUNT(*) as totalRatings FROM Valoraciones WHERE idValorado = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $ratings = $stmt->fetch(PDO::FETCH_ASSOC);
    $ratingAverage = $ratings['ratingAverage'];
    $totalRatings = $ratings['totalRatings'];

} catch (Exception $e) {
    echo "Error al obtener los datos del perfil: " . $e->getMessage();
}

// Función para obtener la clase de estado del producto
function getProductStatusClass($status) {
    switch ($status) {
        case 'Activo':
            return 'badge-success';
        case 'Reservado':
            return 'badge-warning';
        case 'Vendido':
            return 'badge-secondary';
        default:
            return 'badge-light';
    }
}

// Función para obtener la calificación en estrellas
function getStarRating($rating) {
    $stars = '';
    for ($i = 0; $i < 5; $i++) {
        if ($i < floor($rating)) {
            $stars .= '<i class="fas fa-star"></i>';
        } elseif ($i < ceil($rating)) {
            $stars .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $stars .= '<i class="far fa-star"></i>';
        }
    }
    return $stars;
}
?>
