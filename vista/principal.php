<?php include '../includes/header.php'; ?>

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
                <img src="../assets/img/carousel-5.jpg" class="d-block w-100" alt="First Slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First Slide Label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets//img/carousel-4.jpg" class="d-block w-100" alt="Second Slide">
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
        <div class="row">
            <div class="col-md-6">
                <img src="../assets//img/woman-6794789_1280.jpg" class="img-fluid" alt="Imagen">
            </div>
            <div class="col-md-6">
                <h2 class="section-title text-info">How to Sell Used Panties</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <h2 class="section-title text-info">Choose the panties you want to sell.</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="col-md-6">
                <img src="../assets/img/carousel-1.jpg" class="img-fluid" alt="Imagen">
            </div>
        </div>
    </div>

    
</main>

<?php include '../includes/footer.php'; ?>
