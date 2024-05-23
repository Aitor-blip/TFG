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
        $stmt = $conn->prepare("SELECT * FROM Productos WHERE idUsuario = ? AND estado != 'Vendido'");
        $stmt->execute([$_SESSION['user_id']]);
        $productsForSale = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT * FROM Productos WHERE idUsuario = ? AND estado = 'Vendido'");
        $stmt->execute([$_SESSION['user_id']]);
        $productsSold = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Si el usuario es comprador, obtener sus compras
    if ($role == 'comprador') {
        $stmt = $conn->prepare("SELECT P.*, T.fechaTransaccion FROM Productos P
                                INNER JOIN Transacciones T ON P.idProducto = T.idProducto
                                WHERE T.idComprador = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<?php include '../includes/header.php'; ?>

<div class="perfil container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="profile-icon-wrapper">
                <?php 
                // Verificar si la ruta de la imagen es una URL completa o una ruta relativa
                $profileImagePath = htmlspecialchars($user['foto']);
                if (!empty($user['foto']) && (strpos($profileImagePath, 'http') === 0 || file_exists($profileImagePath))): ?>
                    <img src="<?php echo $profileImagePath; ?>" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <?php else: ?>
                    <i class="fas fa-user-circle fa-9x text-muted"></i>
                <?php endif; ?>
            </div>
            <h4><?php echo htmlspecialchars($user['nombreUsuario']); ?></h4>
            <p><?php echo ($totalRatings > 0) ? getStarRating($ratingAverage) . " $ratingAverage de 5 (de $totalRatings valoraciones)" : "Aún no hay valoraciones"; ?></p>
        </div>
        <div class="col-md-9">
            <div class="d-flex flex-column align-items-end">
                <a href="editar_perfil.php" class="btn btn-outline-info mb-2"><i class="fas fa-pencil-alt"></i> Editar perfil</a>
                <form action="borrar_perfil.php" method="post">
                    <input type="hidden" name="confirm_delete" value="yes">
                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> Borrar perfil</button>
                </form>
            </div>
            <p><?php echo htmlspecialchars($user['descripcion']); ?></p>
            <h5>Información verificada:</h5>
            <p><i class="fas fa-check-circle"></i> Google</p>
            <p><i class="fas fa-check-circle"></i> E-mail</p>
        </div>
    </div>
    <hr>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="armario-tab" data-toggle="tab" href="#armario" role="tab" aria-controls="armario" aria-selected="true">Mis Productos</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="armario" role="tabpanel" aria-labelledby="armario-tab">
            <?php if ($role == 'vendedor'): ?>
                <div class="d-flex justify-content-end mt-3">
                    <a href="subir_producto.php" class="btn btn-primary">Subir productos</a>
                </div>
                <h5 class="mt-3">Productos en Venta</h5>
                <div class="row mt-3">
                    <?php foreach ($productsForSale as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 250px; overflow: hidden;">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="Foto del producto" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['nombreProducto']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                                    <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                                    <span class="badge <?php echo getProductStatusClass($product['estado']); ?>"><?php echo htmlspecialchars($product['estado']); ?></span>
                                    <a href="editar_producto.php?id=<?php echo $product['idProducto']; ?>" class="btn btn-warning mt-2">Editar</a>
                                    <a href="borrar_producto.php?id=<?php echo $product['idProducto']; ?>" class="btn btn-danger mt-2">Borrar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($productsForSale)): ?>
                        <div class="col-12 text-center">
                            <p>No tienes productos en venta.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <h5 class="mt-5">Productos Vendidos</h5>
                <div class="row mt-3">
                    <?php foreach ($productsSold as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 250px; overflow: hidden;">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="Foto del producto" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['nombreProducto']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                                    <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                                    <span class="badge <?php echo getProductStatusClass($product['estado']); ?>"><?php echo htmlspecialchars($product['estado']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($productsSold)): ?>
                        <div class="col-12 text-center">
                            <p>No has vendido productos.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif ($role == 'comprador'): ?>
                <h5 class="mt-3">Productos Comprados</h5>
                <div class="row mt-3">
                    <?php foreach ($purchases as $purchase): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 250px; overflow: hidden;">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($purchase['foto']); ?>" class="card-img-top" alt="Foto del producto" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($purchase['nombreProducto']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($purchase['descripcion']); ?></p>
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($purchase['precio']); ?></p>
                                    <p class="card-text"><strong>Fecha de Compra:</strong> <?php echo htmlspecialchars($purchase['fechaTransaccion']); ?></p>
                                    <span class="badge badge-info"><?php echo htmlspecialchars($purchase['estado']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($purchases)): ?>
                        <div class="col-12 text-center">
                            <p>No has realizado ninguna compra.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php include '../includes/footer.php'; ?>
