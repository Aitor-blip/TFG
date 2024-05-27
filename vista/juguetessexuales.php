<?php
session_start();
require_once '../config/conexion.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT p.*, u.nombreUsuario, u.foto as fotoUsuario FROM Productos p 
          JOIN Usuarios u ON p.idUsuario = u.idUsuario 
          WHERE LOWER(p.nombreProducto) = 'juguete sexual' OR p.idCategoria = 4";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Productos de Juguetes Sexuales</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($product['fotoUsuario']); ?>" class="rounded-circle" alt="Foto de usuario" style="width: 40px; height: 40px;">
                        <span class="ml-2"><?php echo htmlspecialchars($product['nombreUsuario']); ?></span>
                    </div>
                    <div style="width: 100%; height: 250px; overflow: hidden;">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="Foto del producto" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['nombreProducto']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                        <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                        <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                        <button class="btn btn-outline-primary" onclick="likeProduct(<?php echo $product['idProducto']; ?>)">
                            <i class="fas fa-heart"></i> <span id="like-count-<?php echo $product['idProducto']; ?>">0</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function likeProduct(productId) {
        let likeCountElem = document.getElementById('like-count-' + productId);
        let currentCount = parseInt(likeCountElem.textContent);
        likeCountElem.textContent = currentCount + 1;
    }
</script>

<?php include '../includes/footer.php'; ?>
