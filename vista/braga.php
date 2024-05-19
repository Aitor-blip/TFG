<body>
    <div class="container mt-5">
        <div class="row">
            <?php
            // Aquí iría tu conexión a la base de datos y la consulta SQL
            // Simularemos con un array estático como ejemplo
            $productos = [
                ['nombre' => 'Braguitas beis otoño', 'precio' => '50€', 'descripcion' => 'Se trata de unas braguitas...', 'imagen' => 'path_to_image1.jpg'],
                ['nombre' => 'Braguitas caca', 'precio' => '50€', 'descripcion' => 'Se trata de unas braguitas...', 'imagen' => 'path_to_image2.jpg'],
                // Añade más productos según necesidad
            ];

            foreach ($productos as $producto) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="' . $producto['imagen'] . '" class="card-img-top" alt="' . $producto['nombre'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $producto['nombre'] . '</h5>
                            <p class="card-text">' . $producto['descripcion'] . '</p>
                            <a href="#" class="btn btn-primary">Comprar ' . $producto['precio'] . '</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>
