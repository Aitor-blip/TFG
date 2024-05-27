 <?php 
    include 'header.php';
    include_once '../clases/login.php';
?>


<div class="container">
        <h2 class="text-center">Registro en DesireCloset</h2>
        <form id="registrationForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                </div>
                <div class="form-group col-md-6">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido">
                </div>
            </div>
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" placeholder="Nombre de Usuario">
                <span id="usernameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" placeholder="Contraseña">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" placeholder="DNI">
                </div>
                <div class="form-group col-md-6">
                    <label for="fecha-nacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha-nacimiento">
                    <span id="ageError" class="text-danger"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" placeholder="Correo Electrónico">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" placeholder="Teléfono">
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(event) {
                event.preventDefault();

                var username = $('#username').val();
                var dateOfBirth = new Date($('#fecha-nacimiento').val());
                var today = new Date();
                var age = today.getFullYear() - dateOfBirth.getFullYear();

                if (age < 18) {
                    $('#ageError').text('Debe ser mayor de 18 años para registrarse');
                    return;
                } else {
                    $('#ageError').text('');
                }

                $.ajax({
                    url: 'check_username.php', // Ruta de tu archivo PHP para verificar el nombre de usuario
                    method: 'POST',
                    data: {username: username},
                    success: function(response) {
                        if (response == 'disponible') {
                            $('#usernameError').text('');
                            // Aquí puedes permitir que el usuario se registre
                            // También puedes enviar el formulario si todo está bien
                            // $('#registrationForm').unbind('submit').submit();
                        } else {
                            $('#usernameError').text('El nombre de usuario no está disponible');
                        }
                    }
                });
            });
        });
    </script>
    <?php include 'footer.php'; ?>