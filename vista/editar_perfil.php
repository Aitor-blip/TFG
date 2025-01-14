

<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/login.php');
    exit;
}

// Obtener información del usuario
$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->prepare("SELECT * FROM Usuarios WHERE idUsuario = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Hashear nueva contraseña si se proporciona
    $nombre = $_POST['nombre'];
    $apellidos1 = $_POST['apellidos1'];
    $apellidos2 = $_POST['apellidos2'];
    $sexo = $_POST['sexo'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $descripcion = $_POST['descripcion'];

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Actualizar usuario en la tabla Usuarios
        $sql = "UPDATE Usuarios SET nombreUsuario = ?, nombre = ?, apellidos1 = ?, apellidos2 = ?, email = ?, sexo = ?, fechaNacimiento = ?, descripcion = ?";
        $params = [$nombreUsuario, $nombre, $apellidos1, $apellidos2, $email, $sexo, $fechaNacimiento, $descripcion];

        if ($password) {
            $sql .= ", password = ?";
            $params[] = $password;
        }

        $sql .= " WHERE idUsuario = ?";
        $params[] = $userId;

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        // Confirmar la transacción
        $conn->commit();

        header('Location: ../vista/miperfil.php?mensaje=Perfil actualizado con éxito.');
        exit;
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollBack();
        echo "Error al actualizar el perfil: " . $e->getMessage();
    }
}
?>


<?php include '../includes/header.php'; ?>

<section class="registro container py-5">
    <h2 class="text-center mb-4">EDITAR PERFIL</h2>
    <form id="editProfileForm" action="editar_perfil.php" method="post" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-3">DATOS DE CUENTA</h4>
                <div class="form-group mb-3">
                    <label for="nombreUsuario" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" value="<?php echo htmlspecialchars($user['nombreUsuario']); ?>" required>
                    <div class="invalid-feedback">Por favor, ingrese su nombre de usuario.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    <div class="invalid-feedback">Por favor, ingrese un correo electrónico válido.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="invalid-feedback">Por favor, ingrese una nueva contraseña si desea cambiarla.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password" class="form-label">Repetir Nueva Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <div class="invalid-feedback">Por favor, confirme su nueva contraseña.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                    <div class="invalid-feedback">Por favor, ingrese su nombre.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="apellidos1" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="apellidos1" name="apellidos1" value="<?php echo htmlspecialchars($user['apellidos1']); ?>" required>
                    <div class="invalid-feedback">Por favor, ingrese su primer apellido.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="apellidos2" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="apellidos2" name="apellidos2" value="<?php echo htmlspecialchars($user['apellidos2']); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="mb-3">DATOS PERFIL</h4>
                <div class="form-group mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Escríbenos un texto sobre ti, gustos y aficiones, saldrá publicado en tu perfil"><?php echo htmlspecialchars($user['descripcion']); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="fecha-nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha-nacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($user['fechaNacimiento']); ?>" required>
                    <div class="invalid-feedback">Por favor, ingrese su fecha de nacimiento.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="" disabled <?php echo empty($user['sexo']) ? 'selected' : ''; ?>>Seleccione su sexo</option>
                        <option value="masculino" <?php echo $user['sexo'] == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="femenino" <?php echo $user['sexo'] == 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                        <option value="otro" <?php echo $user['sexo'] == 'otro' ? 'selected' : ''; ?>>Otro</option>
                    </select>
                    <div class="invalid-feedback">Por favor, seleccione su sexo.</div>
                </div>
                <button type="submit" class="btn btn-info btn-block">ACTUALIZAR PERFIL</button>
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
