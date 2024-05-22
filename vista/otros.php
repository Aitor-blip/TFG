<?php
session_start();
require_once '../config/conexion.php'; // Asegúrate de que la ruta al archivo de conexión sea correcta

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM Productos WHERE idCategoria = 5"; // Asumiendo que 5 es el id de la categoría "Otros"
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php'; // Incluye el header de tu sitio web
?>

<div class="container mt-5">
    <h2 class="mb-4">Productos de Otros</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
