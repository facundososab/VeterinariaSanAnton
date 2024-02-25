<?php

require_once('./config/server.php');
require_once('./config/app.php');

session_start();

if (isset($_SESSION['usuario'])) {
 header('location: pagina-login/login.php');
} 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo APP_NAME; ?></title>
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
  <body>
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
              <a class="nav-link" aria-current="page" href="servicios.php">Servicios</a>
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
              <a class="nav-link" href="contacto.php">Contacto</a>
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
    
    <?php
    
    echo '<main class="pt-5">
      <div
        class="container align-items-center justify-content-center bg-primary-color rounded-4 mb-5"
      >
        <section class="row main-content">
          <article
            class="col-12 col-lg-6 order-lg-1 text-end d-flex flex-column align-items-end align-self-center px-5 pt-3"
          >
            <h1 class="mt-3 display-1">Veterinaria<br />San Antón</h1>
            <p class="pb-1">Dirección de la veterinaria</p>
            <form action="">
              <input
                type="submit"
                class="btn btn-danger rounded-pill fs-4 p-3 mt-4"
                value="TENGO UNA EMERGENCIA"
              />
            </form>
            <p class="fs-5 mt-5"><b>Lugar seguro para tu mascota</b></p>
            <div
              class="reseñas bg-third-color border border-black rounded-4 mb-4 mt-1 w-50 align-items-center pt-2 align-self-lg-end"
            >
              <img src="./img/Avatars1.svg" alt="" class="col-12" />
              <p class="fs-5 text-center col-12">+100 Reseñas</p>
            </div>
            <div
              class="ubicacion d-flex align-items-center mx-auto justify-content-center"
            >
              <img src="./img/garra_izq.svg" alt="" class="img-fluid" />
              <h5 class="mx-2 text-center">
                Ubicada en la ciudad de Rosario, Santa Fe
              </h5>
              <img src="./img/garra_der.svg" alt="" class="img-fluid" />
            </div>
          </article>
          <article class="img col-12 col-lg-6 d-flex">
            <img
              src="./img/dog 1.png"
              alt="Veterinaria San Antón"
              class="h-75 align-self-end img-fluid"
            />
          </article>
        </section>
      </div>
    </main>';


    include_once('./inc/footer.php');



    ?>
 
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
