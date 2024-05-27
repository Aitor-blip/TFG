<?php
session_start();
require_once '../config/conexion.php'; 

$database = new Database();
$db = $database->getConnection();

$query = "SELECT Productos.*, Usuarios.nombreUsuario, Usuarios.foto as fotoPerfil 
          FROM Productos 
          JOIN Usuarios ON Productos.idUsuario = Usuarios.idUsuario 
          WHERE idCategoria = 2";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php'; 
?>

<div class="container mt-5">
    <h2 class="mb-4">Sujetadores</h2>
    <div class="row">
        <?php if (empty($products)): ?>
            <div class="col-12 text-center">
                <p>No hay productos de sujetadores disponibles.</p>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="d-flex align-items-center p-2">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($product['fotoPerfil']); ?>" class="rounded-circle me-2" alt="Foto de perfil" style="width: 50px; height: 50px;">
                            <span><?php echo htmlspecialchars($product['nombreUsuario']); ?></span>
                        </div>
                        <div style="width: 100%; height: 250px; overflow: hidden;">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="Foto del producto" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['nombreProducto']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['descripcion']); ?></p>
                            <p class="card-text"><strong>Precio:</strong> €<?php echo htmlspecialchars($product['precio']); ?></p>
                            <p class="card-text"><strong>Talla:</strong> <?php echo htmlspecialchars($product['talla']); ?></p>
                            <button class="btn btn-light">
                                <i class="fas fa-heart" style="color: red;"></i> <span class="like-count">0</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
    document.querySelectorAll('.btn-light').forEach(button => {
        button.addEventListener('click', function() {
            let count = this.querySelector('.like-count');
            count.textContent = parseInt(count.textContent) + 1;
        });
    });
</script>
