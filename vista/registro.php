<?php include '../includes/header.php'; ?>

<section class="registro container py-5">
    <h2 class="text-center mb-4">REGÍSTRATE COMO NUEVO USUARIO</h2>
    <form id="registrationForm" action="../controlador/registro_controlador.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-12 mb-3">
                <select class="form-select" aria-label="Seleccionar Rol" id="tipoUsuario" name="tipoUsuario" required>
                    <option value="" disabled selected>Seleccione un rol</option>
                    <option value="comprador">Comprador</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-3">DATOS DE CUENTA</h4>
                <div class="form-group mb-3">
                    <label for="nombreUsuario" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                    <div class="invalid-feedback">Por favor, ingrese su nombre de usuario.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Por favor, ingrese una contraseña.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password" class="form-label">Repetir Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <div class="invalid-feedback">Por favor, confirme su contraseña.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="apellidos1" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="apellidos1" name="apellidos1" required>
                    <div class="invalid-feedback">Por favor, ingrese su primer apellido.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="apellidos2" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="apellidos2" name="apellidos2">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">Acepto los <a href="#">términos y condiciones legales</a></label>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="age" required>
                    <label class="form-check-label" for="age">Acepto que soy mayor de edad</label>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="mb-3">DATOS PERFIL</h4>
                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Foto de Perfil</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Escríbenos un texto sobre ti, gustos y aficiones, saldrá publicado en tu perfil"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                    <div class="invalid-feedback">Por favor, ingrese su fecha de nacimiento.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="" disabled selected>Seleccione su sexo</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select>
                    <div class="invalid-feedback">Por favor, seleccione su sexo.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="dni" class="form-label">Foto de DNI</label>
                    <input type="file" class="form-control" id="dni" name="dni" required>
                    <div class="invalid-feedback">Por favor, suba una foto de su DNI.</div>
                </div>
                <button type="submit" class="btn btn-info btn-block">REGISTRARSE</button>
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
