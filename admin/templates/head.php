<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DesireCloset</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">

  
</head>
<body>
    
     <!--========================================================== -->
<!--ENCABEZADO-->
<!--========================================================== -->
<header class="copyright py-3" style="background-color: #000000;">
    <div class="container px-0">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center">
                    <a href="#" class="navbar-brand">
                        <img src="../../img/logo.jpg" alt="Logo de DesireCloset" class="logo" style="width:100px;">
                    </a>
                    <div class="ms-2">
                        <h2 class="text-info display-6 mb-0">DesireCloset</h2>
                        <h5 class="text-info text-center display-10 mb-0">Conectando Fantasias</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Iconos de inicio de sesión y registro -->
                    <a href="inicio_sesion.php" class="btn btn-light btn-lg btn-outline-white rounded-pill py-0 px-2 me-3"><i class="fas fa-sign-in-alt text-dark me-2"></i></a>
                    <a href="registro.php" class="btn btn-light btn-lg btn-outline-white rounded-pill py-0 px-2"><i class="fas fa-user-plus text-dark me-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>

<!--========================================================== -->
<!--BARRA DE NAVEGACIÓN-->
<!--========================================================== -->
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto border-top">
                <li class="nav-item">
                    <a href="../secciones/principal.php" class="nav-link active ml-2 fs-4">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="../secciones/contacto.php" class="nav-link ml-2 fs-4">Contacto</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ml-2 fs-4">Blog</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle ml-2 fs-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Bragas y Tangas</a>
                        <a href="#" class="dropdown-item">Sujetadores</a>
                        <a href="#" class="dropdown-item">Fotos de pies</a>
                        <a href="#" class="dropdown-item">Juguetes sexuales</a>
                        <a href="#" class="dropdown-item">Otros</a>
                       
                    </div>
                </li>
                <li class="nav-item dropdown">
                   <a href="#" class="nav-link dropdown-toggle ml-2 fs-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mas</a>
                      
                    <ul class="dropdown-menu" >
                        <li><a class="dropdown-item" href="../secciones/preguntas.php">Preguntas Frecuentes</a></li>
                        <li><a class="dropdown-item" href="#">Política de Privacidad</a></li>
                        <li><a class="dropdown-item" href="#">Términos de Servicio</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex me-3" action="ruta_de_busqueda.php" method="GET">
                <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar" aria-label="Buscar">
                <a href="ruta_de_busqueda.php" class="btn btn-info">
                    <i class="fas fa-search"></i>
                </a>
            </form>
            <!-- Iconos de inicio de sesión y registro -->
            <ul class="navbar-nav">
               <li class="nav-item">
    <a class="nav-link" href="miperfil.php">
        <i class="fas fa-user fa-lg"></i> <!-- Icono de perfil -->
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="carrito.php">
        <i class="fas fa-shopping-cart fa-lg"></i> <!-- Icono de carrito -->
    </a>
</li>
            </ul>
        </div>
    </div>
</nav>

