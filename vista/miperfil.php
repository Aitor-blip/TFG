<?php
// Incluye el controlador del perfil
require_once '../controlador/perfil_controlador.php';
?>

<?php include '../includes/header.php'; ?>

<div class="perfil container mt-5">
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="profile-icon-wrapper">
                <?php if (!empty($user['foto'])): ?>
                    <img src="/assets/img/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <?php else: ?>
                    <i class="fas fa-user-circle fa-9x text-muted"></i>
                <?php endif; ?>
            </div>
            <h4><?php echo htmlspecialchars($user['nombreUsuario']); ?></h4>
            <p><?php echo ($totalRatings > 0) ? getStarRating($ratingAverage) . " $ratingAverage de 5 (de $totalRatings valoraciones)" : "Aún no hay valoraciones"; ?></p>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between">
                <h4>Sobre mí</h4>
                <a href="editar_perfil.php" class="btn btn-outline-primary"><i class="fas fa-pencil-alt"></i> Editar perfil</a>
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
            <div class="row mt-3">
                <?php if ($role == 'vendedor'): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="/assets/img/<?php echo htmlspecialchars($product['foto']); ?>" class="card-img-top" alt="Foto del producto">
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
                    <?php if (empty($products)): ?>
                        <div class="col-12 text-center">
                            <p>No tienes productos en tu armario.</p>
                            <a href="subir_producto.php" class="btn btn-primary">Subir productos</a>
                        </div>
                    <?php endif; ?>
                <?php elseif ($role == 'comprador'): ?>
                    <?php foreach ($purchases as $purchase): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="/assets/img/<?php echo htmlspecialchars($purchase['foto']); ?>" class="card-img-top" alt="Foto del producto">
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
                <?php endif; ?>
            </div>
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
