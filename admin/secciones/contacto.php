  <?php include '../templates/header.php'; ?>

<div class="container">
    <div class="col-12 col-md-12">
    <div class="row">
                <h1 class="text-center mt-2 mb-5">CONTACTO</h1>
                <?php
                // Verificar si se ha enviado el formulario
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Recibir los datos del formulario
                    $nombre = $_POST['nombre'];
                    $email = $_POST['email'];
                    $mensaje = $_POST['mensaje'];

                    // Configurar el correo electrónico
                    $destinatario = "tudirecciondecorreo@example.com"; // Cambiar por tu dirección de correo electrónico
                    $asunto = "Nuevo mensaje de contacto de Vinted";

                    // Construir el cuerpo del correo
                    $cuerpo = "Nombre: $nombre\n";
                    $cuerpo .= "Email: $email\n\n";
                    $cuerpo .= "Mensaje:\n$mensaje";

                    // Enviar el correo electrónico
                    if (mail($destinatario, $asunto, $cuerpo)) {
                        // Si el correo se envió correctamente, mostrar un mensaje de éxito
                        echo '<div class="alert alert-success" role="alert">Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.</div>';
                    } else {
                        // Si hubo un error al enviar el correo, mostrar un mensaje de error
                        echo '<div class="alert alert-danger" role="alert">Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.</div>';
                    }
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje:</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-info mt-5">Enviar Mensaje</button>
                </form>
            </div>
        </div>


        
    </div>
  <?php include '../templates/footer.php'; ?>