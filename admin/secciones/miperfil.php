<?php include 'header.php'; ?>
<body>
    <div class="container">
      <?php
        // Establecer conexión con la base de datos
        $servername = "localhost"; 
        $username = "oly"; // Cambiar por tu nombre de usuario de MySQL
        $password = ""; // Cambiar por tu contraseña de MySQL
        $database = "desirecloset"; // Cambiar por el nombre de tu base de datos

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener los datos del usuario y sus productos
        $sql_usuario = "SELECT * FROM usuarios WHERE idUsuario = 1"; // Cambiar el ID del usuario según corresponda
        $result_usuario = $conn->query($sql_usuario);

        if ($result_usuario->num_rows > 0) {
            $row_usuario = $result_usuario->fetch_assoc();
            echo '<div class="text-center my-4">';
            echo '<img src="' . $row_usuario["fotoPerfil"] . '" alt="Foto de Perfil" class="img-fluid rounded-circle" style="width: 150px;">';
            echo '<h2>' . $row_usuario["nombreUsuario"] . '</h2>';
            echo '</div>';

            // Consulta para obtener los productos del usuario
            $sql_productos = "SELECT * FROM productos WHERE idUsuario = 1"; // Cambiar el ID del usuario según corresponda
            $result_productos = $conn->query($sql_productos);

            echo '<h3 class="my-4">Mis Productos</h3>';
            echo '<div class="row">';
            while ($row_producto = $result_productos->fetch_assoc()) {
                echo '<div class="col-md-4 mb-3">';
                echo '<div class="card">';
                echo '<img src="' . $row_producto["foto"] . '" class="card-img-top" alt="' . $row_producto["nombreProducto"] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row_producto["nombreProducto"] . '</h5>';
                // Más detalles sobre el producto, como precio, descripción, etc.
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }

        // Consulta para obtener las valoraciones del usuario
        $sql_valoraciones = "SELECT * FROM valoraciones WHERE idValorado = 1"; // Cambiar el ID del usuario según corresponda
        $result_valoraciones = $conn->query($sql_valoraciones);

        echo '<h3 class="my-4">Mis Valoraciones</h3>';
        echo '<div class="row">';
        while ($row_valoracion = $result_valoraciones->fetch_assoc()) {
            echo '<div class="col-md-6 mb-3">';
            echo '<div class="card">';
            echo '<div class="card-header">';
            echo 'Valoración de Usuario ' . $row_valoracion["idValorador"];
            echo '</div>';
            echo '<div class="card-body">';
            echo '<p class="card-text">' . $row_valoracion["comentario"] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        // Cerrar conexión
        $conn->close();
        ?> 
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>