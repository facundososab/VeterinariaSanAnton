<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Servicios</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="img/logo.svg" />
  </head>
  <body class="min-vh-100 d-flex flex-column">
    <nav
      class="navbar sticky-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow"
    >
      <div class="container">

        <a class="navbar-brand" href="index.php"
          ><img src="./img/logo.svg" alt="Veterinaria San Antón"
        /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse row" id="navbarNavDropdown">
          <ul
            class="navbar-nav mb-2 mb-lg-0 align-items-center justify-content-lg-evenly col-lg-9"
          >
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="servicios.php">Servicios</a>
            </li>

      <?php
      /* NAV CLIENTE */
            if (isset($_SESSION['usuario']) && $_SESSION['rol_id'] == 4) {
            echo '<li class="nav-item">
              <a class="nav-link" href="#">Turnos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Historial<br />Médico</a>
            </li>';

            }

      ?>

            <li class="nav-item">
              <a class="nav-link active" href="contacto.php">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sobre_nosotros.php">Sobre<br />nosotros</a>
            </li>
          </ul>
  
  <?php
          if (!isset($_SESSION['usuario'])) {
          echo 
          '<div class="registro row col-lg-3 mx-auto">
            <a href="./pagina-login/login.php" 
            class="btn btn1-bg-color rounded-pill col-12 col-lg-5 p-2 me-lg-1 mb-2 mb-lg-0">Ingresa</a>
            <a href="" class="btn btn2-bg-color rounded-pill p-2 col-12 col-lg-6">Registrate</a>
            
            </div>';//Modifdique en la linea 53 el col-lg del boton registrarte porque 
            //no se veia todo, habria que ver que queden iguales y les puse el p-2 asi quedan completas
            
        } else {
                echo 'Usuario no registrado ';
        }

    ?>
          
        </div>
      </div>
    </nav>
    <main class="py-5 d-flex flex-grow-1 justify-content-center align-items-stretch">
      <div class="container d-flex mx-2">
            <section class="row flex-grow-1 bg-primary-color rounded-5">
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-between pt-4 ps-4">
                      <h1 class="text-center m-5">Contactanos</h1>
                      <img src="./img/img_contacto.svg" alt="Contacto" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-6 py-4 px-5 d-flex justify-content-center align-items-center">
                      <form action="https://formsubmit.co/sanantonveterinaria123@gmail.com" id="formulario" method="post" class="w-100">
                        <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" id="email" name="email" required>
                          <p id="emailError" class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                          <label for="asunto" class="form-label">Asunto</label>
                          <input type="text" class="form-control" id="asunto" name="asunto" required>
                          <p id="asuntoError" class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                          <label for="mensaje" class="form-label">Mensaje</label>
                          <textarea class="form-control" id="mensaje" name="mensaje" required></textarea>
                          <p id="mensajeError" class="text-danger"></p>
                        </div>
                        <button type="submit" class="btn btn-primary w-75 mx-auto">Enviar</button>
                        <input type="hidden" name="_template" value="box">
                        <input type="hidden" name="_subject" value="Nueva consulta!">
                        <input type="hidden" name="_autoresponse" value="Gracias por contactarse con Veterinaria San Antón. Trataremos de darte una respuesta lo más pronto posible!">
                      </form>
                    </div>
            </section>
          </div>
    </main>

    <?php include_once 'footer.php'; ?>

    <script>
      // Función para validar el formulario de contacto
          function validarFormulario() {
              // Obtener los valores ingresados por el usuario
              var email = document.getElementById("email").value;
              var asunto = document.getElementById("asunto").value;
              var mensaje = document.getElementById("mensaje").value;
              var emailError = document.getElementById("emailError");
              var asuntoError = document.getElementById("asuntoError");
              var mensajeError = document.getElementById("mensajeError");

              // Expresión regular para validar el formato del correo electrónico
              var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

              // Validar el email
              const emailValido = (email) => {
                return emailRegex.test(email);
              };

              if (!emailValido(email)) {
                emailError.innerHTML = "El email no es válido";
                return;
              }

              // Validar el asunto
              const asuntoValido = (asunto) => {
                return asunto.length <= 50;
              };

              if (!asuntoValido(asunto)) {
                asuntoError.innerHTML = "El asunto no puede superar los 50 caracteres";
                return;
              }
              
              // Validar el mensaje
              const mensajeValido = (mensaje) => {
                return mensaje.length <= 256;
              };

              if (!mensajeValido(mensaje)) {
                mensajeError.innerHTML = "El mensaje no puede superar los 256 caracteres";
                return;
              }

              formulario.submit();

              
          }

          // Asignar la función validarFormulario al evento submit del formulario
          document.getElementById("formulario");
          formulario.addEventListener("submit", validarFormulario);
    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>