<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../controlador/borrar_perfil_controlador.php';
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Borrar Perfil</h2>
    <div class="alert alert-danger text-center" role="alert">
        ¿Estás seguro de que deseas borrar tu perfil? Esta acción no se puede deshacer.
    </div>
    <div class="d-flex justify-content-center">
        <form action="../controlador/borrar_perfil_controlador.php" method="post">
            <input type="hidden" name="confirm_delete" value="yes">
            <button type="submit" class="btn btn-danger mx-2">Sí, borrar mi perfil</button>
            <a href="miperfil.php" class="btn btn-secondary mx-2">Cancelar</a>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
