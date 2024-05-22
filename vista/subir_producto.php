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