<?php
require_once '../config/conexion.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
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
        header('Location: login.php');
        exit();
    }

    // Obtener calificación del usuario
    $stmt = $conn->prepare("SELECT AVG(valoracion) as ratingAverage, COUNT(*) as totalRatings FROM Valoraciones WHERE idValorado = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $ratings = $stmt->fetch(PDO::FETCH_ASSOC);
    $ratingAverage = isset($ratings['ratingAverage']) ? $ratings['ratingAverage'] : 0;
    $totalRatings = isset($ratings['totalRatings']) ? $ratings['totalRatings'] : 0;

} catch (Exception $e) {
    echo "Error al obtener los datos del perfil: " . $e->getMessage();
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
                $profileImagePath = htmlspecialchars($user['foto']);
                if (!empty($user['foto']) && file_exists($profileImagePath)): ?>
                    <img src="<?php echo $profileImagePath; ?>" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <?php else: ?>
                    <i class="fas fa-user-circle fa-9x text-muted"></i>
                <?php endif; ?>
            </div>
            <h4><?php echo htmlspecialchars($user['nombreUsuario']); ?></h4>
            <p><?php echo ($totalRatings > 0) ? getStarRating($ratingAverage) . " " . number_format($ratingAverage, 1) . " de 5 (de $totalRatings valoraciones)" : "Aún no hay valoraciones"; ?></p>
        </div>
        <div class="col-md-9">
            <p><?php echo htmlspecialchars($user['descripcion']); ?></p>
            <h5>Información verificada:</h5>
            <p><i class="fas fa-check-circle"></i> Google</p>
            <p><i class="fas fa-check-circle"></i> E-mail</p>
        </div>
    </div>
    
    <hr>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="productos-tab" data-toggle="tab" href="#productos" role="tab" aria-controls="productos" aria-selected="true">Mis Productos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="vendidos-tab" data-toggle="tab" href="#vendidos" role="tab" aria-controls="vendidos" aria-selected="false">Vendidos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="comprados-tab" data-toggle="tab" href="#comprados" role="tab" aria-controls="comprados" aria-selected="false">Comprados</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="productos" role="tabpanel" aria-labelledby="productos-tab">
            <?php
            // Obtener productos en venta (estado NULL)
            $stmt = $conn->prepare("SELECT * FROM Productos WHERE idUsuario = ? AND estado IS NULL");
            $stmt->execute([$_SESSION['user_id']]);
            $productsForSale = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="d-flex justify-content-end mt-3">
                <a href="subir_producto.php" class="btn btn-primary btn-subir-productos">Subir productos</a>
            </div>
            <h5 class="mt-3">Productos en Venta</h5>
            <div class="row mt-3">
                <?php if (!empty($productsForSale)): ?>
                    <?php foreach ($productsForSale as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 300px; overflow: hidden;">
                                    <?php
                                    $stmtFotos = $conn->prepare("SELECT nombreFoto FROM Fotos WHERE idProducto = ?");
                                    $stmtFotos->execute([$product['idProducto']]);
                                    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);
                                    if (!empty($fotos)) {
                                        foreach ($fotos as $foto) {
                                            echo '<img src="' . htmlspecialchars($foto['nombreFoto']) . '" class="card-img-top" alt="Foto del producto" style="height: 300px; width: 100%; object-fit: cover;">';
                                            break; // Solo mostrar la primera foto
                                        }
                                    } else {
                                        echo '<p>No hay fotos disponibles</p>';
                                    }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                                    <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No tienes productos en venta.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="tab-pane fade" id="vendidos" role="tabpanel" aria-labelledby="vendidos-tab">
            <?php
            // Obtener productos vendidos (estado 'vendido')
            $stmt = $conn->prepare("SELECT * FROM Productos WHERE idUsuario = ? AND estado = 'vendido'");
            $stmt->execute([$_SESSION['user_id']]);
            $productsSold = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h5 class="mt-3">Productos Vendidos</h5>
            <div class="row mt-3">
                <?php if (!empty($productsSold)): ?>
                    <?php foreach ($productsSold as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 300px; overflow: hidden;">
                                    <?php
                                    $stmtFotos = $conn->prepare("SELECT nombreFoto FROM Fotos WHERE idProducto = ?");
                                    $stmtFotos->execute([$product['idProducto']]);
                                    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);
                                    if (!empty($fotos)) {
                                        foreach ($fotos as $foto) {
                                            echo '<img src="' . htmlspecialchars($foto['nombreFoto']) . '" class="card-img-top" alt="Foto del producto" style="height: 300px; width: 100%; object-fit: cover;">';
                                            break; // Solo mostrar la primera foto
                                        }
                                    } else {
                                        echo '<p>No hay fotos disponibles</p>';
                                    }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                                    <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No has vendido productos.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="tab-pane fade" id="comprados" role="tabpanel" aria-labelledby="comprados-tab">
            <?php
            // Obtener productos comprados por el usuario
            $stmt = $conn->prepare("SELECT P.*, T.fechaTransaccion FROM Productos P
                                    INNER JOIN Transacciones T ON P.idProducto = T.idProducto
                                    WHERE T.idComprador = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h5 class="mt-3">Productos Comprados</h5>
            <div class="row mt-3">
                <?php if (!empty($purchases)): ?>
                    <?php foreach ($purchases as $purchase): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div style="width: 100%; height: 300px; overflow: hidden;">
                                    <?php
                                    $stmtFotos = $conn->prepare("SELECT nombreFoto FROM Fotos WHERE idProducto = ?");
                                    $stmtFotos->execute([$purchase['idProducto']]);
                                    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);
                                    if (!empty($fotos)) {
                                        foreach ($fotos as $foto) {
                                            echo '<img src="' . htmlspecialchars($foto['nombreFoto']) . '" class="card-img-top" alt="Foto del producto" style="height: 300px; width: 100%; object-fit: cover;">';
                                            break; // Solo mostrar la primera foto
                                        }
                                    } else {
                                        echo '<p>No hay fotos disponibles</p>';
                                    }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($purchase['precio']); ?></p>
                                    <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($purchase['talla']); ?></p>
                                    <p class="card-text"><strong>Fecha de Compra:</strong> <?php echo htmlspecialchars($purchase['fechaTransaccion']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No has realizado ninguna compra.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/validacion.js"></script>
<?php include '../includes/footer.php'; ?>
