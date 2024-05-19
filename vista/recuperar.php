<?php include '../includes/header.php'; ?>

<section class="recuperar container py-5">
    <h2 class="text-center mb-4">RECUPERAR CONTRASEÑA</h2>
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success text-center"><?php echo $_GET['mensaje']; ?></div>
    <?php endif; ?>
    <form id="recuperarForm" action="../controlador/recuperar_controlador.php" method="post" class="needs-validation" novalidate>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Por favor, ingrese su correo electrónico.</div>
                </div>
                <button type="submit" class="btn btn-info btn-block">RECUPERAR CONTRASEÑA</button>
                <p class="text-center mt-3"><a href="login.php">Volver a Iniciar Sesión</a></p>
            </div>
        </div>
    </form>
</section>

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
