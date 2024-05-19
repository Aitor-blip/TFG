<?php include '../includes/header.php'; ?>

<section class="login container py-5">
    <h2 class="text-center mb-4">INICIAR SESIÓN</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <form id="loginForm" action="../controlador/login_controlador.php" method="post" class="needs-validation" novalidate>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Por favor, ingrese su correo electrónico.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Por favor, ingrese su contraseña.</div>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                    <label class="form-check-label" for="rememberMe">Recuérdame</label>
                </div>
                <button type="submit" class="btn btn-info btn-block">INICIAR SESIÓN</button>
                <p class="text-center mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                <p class="text-center mt-3"><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>
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
