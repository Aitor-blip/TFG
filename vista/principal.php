<?php
session_start();
require_once '../config/conexion.php';
$database = new Database();
$conn = $database->getConnection();
$idRol = $database->getIdRolByEmailUser($_SESSION['email']);

// Conectar a la base de datos


// Obtener usuarios
$query = "SELECT nombreUsuario, foto FROM Usuarios";
$stmt = $conn->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    

include '../includes/header.php';
?>

<main>
    <!-- Carrusel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/img/carousel1.jpg" class="d-block w-100" alt="First Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First Slide Label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/carousel2.jpg" class="d-block w-100" alt="Second Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second Slide Label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/carousel-8.jpg" class="d-block w-100" alt="Third Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third Slide Label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Secciones de Contenido -->
    <div class="container mt-4">
        <h1 class="section-title text-danger text-center">Buy and Sell Used Lingerie</h1>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="../assets/img/principal1.jpg" class="img-fluid" alt="Imagen">
            </div>
            <div class="col-md-6">
                <h2 class="section-title text-danger">How to Sell Used Panties</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <h2 class="section-title text-danger">Choose the panties you want to sell.</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="col-md-6">
                <img src="../assets/img/principal-2.jpg" class="img-fluid" alt="Imagen">
            </div>
        </div>

        <!-- Usuarios -->
        <h2 class="section-title text-danger mt-5">Meet Our Sellers</h2>
        <div class="row mt-3">
            <?php foreach ($usuarios as $usuario): ?>
                <div class="col-md-3 text-center mb-4">
                    <?php if (!empty($usuario['foto']) && file_exists("../assets/uploads/" . $usuario['foto'])): ?>
                        <img src="../assets/uploads/<?php echo htmlspecialchars($usuario['foto']); ?>" class="img-fluid rounded-circle mb-2" alt="<?php echo htmlspecialchars($usuario['nombreUsuario']); ?>" style="width: 150px; height: 150px;">
                    <?php else: ?>
                        <img src="../assets/img/default-profile.png" class="img-fluid rounded-circle mb-2" alt="Default Profile" style="width: 150px; height: 150px;">
                    <?php endif; ?>
                    <h5 class="text-danger"><?php echo htmlspecialchars($usuario['nombreUsuario']); ?></h5>
                </div>
            <?php endforeach; ?>
            <?php if (empty($usuarios)): ?>
                <div class="col-12 text-center">
                    <p class="text-danger">No users found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
