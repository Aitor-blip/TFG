<?php
session_start();
require_once '../config/conexion.php'; // Ajusta la ruta al archivo de conexión

// Verificar si el usuario está autenticado y es vendedor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'vendedor') {
    header("Location: ../vista/login.php");
    exit();
}

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['nombreProducto'];
    $talla = $_POST['talla'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $condicion = $_POST['condicion'];
    $idCategoria = $_POST['idCategoria'];
    $idUsuario = $_SESSION['user_id'];
    $foto = $_FILES['foto']['name'];

    // Ruta de la carpeta de destino
    $target_dir = "../assets/uploads/";

    // Verificar si la carpeta de destino existe, si no, crearla
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Ruta completa del archivo
    $target_file = $target_dir . basename($foto);

    // Mover el archivo subido a la carpeta de destino
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
        // Establecer la conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();

        try {
            // Insertar producto en la base de datos
            $query = "INSERT INTO Productos (nombreProducto, talla, descripcion, precio, condicion, foto, idUsuario, idCategoria) 
                      VALUES (:nombreProducto, :talla, :descripcion, :precio, :condicion, :foto, :idUsuario, :idCategoria)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombreProducto', $nombreProducto);
            $stmt->bindParam(':talla', $talla);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':condicion', $condicion);
            $stmt->bindParam(':foto', $target_file);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idCategoria', $idCategoria);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Producto subido con éxito.";
            } else {
                $_SESSION['error'] = "Error al insertar el producto en la base de datos: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Error al subir la foto del producto.";
    }

    header("Location: ../vista/miperfil.php");
    exit();
} else {
    header("Location: ../vista/subir_producto.php");
    exit();
}
?>


<?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <div class="registro_producto">
            <h2 class="mb-4">Subir Producto</h2>
            <form action="../controlador/subir_producto_controlador.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
                </div>
                <div class="mb-3">
                    <label for="talla" class="form-label">Talla</label>
                    <input type="text" class="form-control" id="talla" name="talla" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio (€)</label>
                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="condicion" class="form-label">Condición</label>
                    <input type="text" class="form-control" id="condicion" name="condicion" required>
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
                    <label for="foto" class="form-label">Foto del Producto</label>
                    <input type="file" class="form-control" id="foto" name="foto" required>
                </div>
                <button type="submit" class="btn btn-info">Subir Producto</button>
            </form>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>