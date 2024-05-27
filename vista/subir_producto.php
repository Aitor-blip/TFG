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

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['nombreProducto'];
    $talla = $_POST['talla'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $condicion = $_POST['condicion'];
    $idCategoria = $_POST['idCategoria'];
    $idUsuario = $_SESSION['user_id'];

    // Verificar si se han subido fotos
    if (isset($_FILES['fotos']) && count($_FILES['fotos']['name']) > 0) {
        $fotos = $_FILES['fotos'];

        // Verificar el número de fotos subidas
        if (count($fotos['name']) > 3) {
            $error_message = "Puedes subir un máximo de 3 fotos.";
        } else {
            // Ruta de la carpeta de destino
            $target_dir = "../assets/uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            try {
                // Insertar producto en la base de datos
                $query = "INSERT INTO Productos (nombreProducto, talla, descripcion, precio, condicion, estado, idUsuario, idCategoria) 
                          VALUES (:nombreProducto, :talla, :descripcion, :precio, :condicion, NULL, :idUsuario, :idCategoria)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':nombreProducto', $nombreProducto);
                $stmt->bindParam(':talla', $talla);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':condicion', $condicion);
                $stmt->bindParam(':idUsuario', $idUsuario);
                $stmt->bindParam(':idCategoria', $idCategoria);

                if ($stmt->execute()) {
                    $idProducto = $conn->lastInsertId();
                    for ($i = 0; $i < count($fotos['name']); $i++) {
                        $foto_name = basename($fotos['name'][$i]);
                        $target_file = $target_dir . $foto_name;
                        if (move_uploaded_file($fotos['tmp_name'][$i], $target_file)) {
                            $foto_query = "INSERT INTO Fotos (nombreFoto, idProducto, idUsuario) VALUES (:nombreFoto, :idProducto, :idUsuario)";
                            $foto_stmt = $conn->prepare($foto_query);
                            $foto_stmt->bindParam(':nombreFoto', $target_file);
                            $foto_stmt->bindParam(':idProducto', $idProducto);
                            $foto_stmt->bindParam(':idUsuario', $idUsuario);
                            if (!$foto_stmt->execute()) {
                                $error_message .= "Error al insertar la foto en la base de datos: " . $foto_stmt->errorInfo()[2] . "<br>";
                            }
                        } else {
                            $error_message .= "Error al subir la foto: " . $fotos['name'][$i] . "<br>";
                        }
                    }
                    $success_message = "Producto subido con éxito.";
                } else {
                    $error_message = "Error al insertar el producto en la base de datos: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        }
    } else {
        $error_message = "Debes subir al menos una foto.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="registro_producto card p-4 shadow">
        <h2 class="mb-4 text-center text-danger">Subir Producto</h2>
        <form action="subir_producto.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                </div>
                <div class="col-md-6">
                    <label for="talla" class="form-label">Talla</label>
                    <input type="text" class="form-control" id="talla" name="talla" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio (€)</label>
                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label for="condicion" class="form-label">Condición</label>
                    <input type="text" class="form-control" id="condicion" name="condicion" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="idCategoria" class="form-label">Categoría</label>
                <select class="form-control" id="idCategoria" name="idCategoria" required>
                    <option value="1">Bragas y Tangas</option>
                    <option value="2">Sujetadores</option>
                    <option value="3">Fotos de pies</option>
                    <option value="4">Juguetes sexuales</option>
                    <option value="5">Otros</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Fotos del Producto (máximo 3)</label>
                <input type="file" class="form-control" id="fotos" name="fotos[]" multiple required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="miperfil.php" class="btn btn-dark">Volver</a>
                <button type="submit" class="btn btn-subir-productos">Subir Producto</button>
            </div>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
