<?php

require_once('./config/server.php');
require_once('./config/app.php');

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
    <?php
    
    include_once('./inc/header.php');
/*     use App\Models\User;
    $user = new User();

    $consulta = $user->get_users(); */
    
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
