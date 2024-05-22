<?php
session_start();
require_once '../config/conexion.php'; // Ajusta la ruta al archivo de conexión
include '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendedor') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM Productos WHERE idProducto = :idProducto AND idUsuario = :idUsuario";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idProducto', $idProducto);
    $stmt->bindParam(':idUsuario', $_SESSION['user_id']);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        $_SESSION['error'] = "Producto no encontrado.";
        header("Location: perfil.php");
        exit();
    }
} else {
    header("Location: perfil.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="registro_producto">
        <h2 class="mb-4">Editar Producto</h2>
        <?php
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="../controlador/editar_producto_controlador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idProducto" value="<?= htmlspecialchars($producto['idProducto']) ?>">
            <div class="mb-3">
                <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" value="<?= htmlspecialchars($producto['nombreProducto']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="talla" class="form-label">Talla</label>
                <input type="text" class="form-control" id="talla" name="talla" value="<?= htmlspecialchars($producto['talla']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio (€)</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="condicion" class="form-label">Condición</label>
                <input type="text" class="form-control" id="condicion" name="condicion" value="<?= htmlspecialchars($producto['condicion']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="idCategoria" class="form-label">Categoría</label>
                <select class="form-control" id="idCategoria" name="idCategoria" required>
                    <option value="1" <?= $producto['idCategoria'] == 1 ? 'selected' : '' ?>>Bragas y Tangas</option>
                    <option value="2" <?= $producto['idCategoria'] == 2 ? 'selected' : '' ?>>Sujetadores</option>
                    <option value="3" <?= $producto['idCategoria'] == 3 ? 'selected' : '' ?>>Fotos de pies</option>
                    <option value="4" <?= $producto['idCategoria'] == 4 ? 'selected' : '' ?>>Juguetes sexuales</option>
                    <option value="5" <?= $producto['idCategoria'] == 5 ? 'selected' : '' ?>>Otros</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto del Producto</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <input type="hidden" name="fotoActual" value="<?= htmlspecialchars($producto['foto']) ?>">
            </div>
            <button type="submit" class="btn btn-info">Actualizar Producto</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
