<?php
session_start();
require_once '../config/conexion.php'; // Asegúrate de que la ruta al archivo de conexión sea correcta

$database = new Database();
$db = $database->getConnection();

$query = "SELECT p.*, c.nombreCategoria FROM Productos p JOIN Categorias c ON p.idCategoria = c.idCategoria ORDER BY p.idCategoria";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php'; // Incluye el header de tu sitio web
?>

<div class="container mt-5">
    <h2 class="mb-4">Todos los Productos</h2>
    <?php
    $currentCategory = '';
    foreach ($products as $product):
        if ($currentCategory != $product['nombreCategoria']):
            if ($currentCategory != ''): ?>
                </div> <!-- Close the previous category's row -->
            <?php endif;
            $currentCategory = $product['nombreCategoria']; ?>
            <h3 class="mb-4"><?php echo htmlspecialchars($currentCategory); ?></h3>
            <div class="row">
        <?php endif; ?>
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
    <?php endforeach;
    if ($currentCategory != ''): ?>
        </div> <!-- Close the last category's row -->
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
