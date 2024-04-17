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
    <main>
      <div class="container service-text-color">
        <section class="row bg-service-color rounded-5 p-4 mt-4 mb-2">
          <div class="col-12 col-md-6">
            <h2>
              ¿Te preocupa el estado <br />
              de tu mascota?
            </h2>
            <br />
            <p>Mirá los servicios que ofrecemos servicios</p>
          </div>
          <div class="col-12 col-md-6 d-flex">
            <img src="img/ser1.svg" alt="" class="img-servicios-1 mx-auto" />
          </div>
        </section>
        <div class="row">
          <section class="col-12 col-lg-7 flex-grow-1 me-lg-2">
            <div class="row">
              <div class="col-12 bg-service-color rounded-5 p-4 my-3">
                <div class="row align-items-center">
                  <div class="col-12 col-sm-8">
                    <h3>Sanidad</h3>
                    <br />
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Diagnóstico exacto de enfermedades animales</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5">Controles sanitarios</i>
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Análisis completos de sangre y orina</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Ecografía y radiología digital (rayos X)</i
                      >
                    </p>
                  </div>
                  <div
                    class="col-12 col-sm-4 d-flex align-items-center justify-content-center"
                  >
                    <img src="img/ser2.svg" alt="" class="mx-auto" />
                  </div>
                </div>
              </div>
              <div class="col-sm-12 bg-service-color rounded-5 p-4 my-2">
                <div class="row">
                  <h3>Hospitalización</h3>
                  <div class="col-12 col-sm-5">
                    <br />
                    <p>
                      <i class="bi bi-arrow-right fs-5">
                        Servicios de cuidado de animales</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Inmunización pasiva con suero</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Micro y macro terapia de llenado</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Rehabilitación y mantenimiento diario</i
                      >
                    </p>
                  </div>
                  <div class="col-12 col-sm-3">
                    <br />
                    <p>
                      <i class="bi bi-arrow-right fs-5"
                        >Transfusión de sangre</i
                      >
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5">Dietología</i>
                    </p>
                    <p>
                      <i class="bi bi-arrow-right fs-5">Ayuda urgente</i>
                    </p>
                  </div>
                  <div
                    class="col-12 col-sm-4 d-flex align-items-center justify-content-center"
                  >
                    <img src="img/ser4.svg" alt="" class="mx-auto" />
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section
            class="col-12 col-lg-4 bg-service-color rounded-5 d-flex flex-column mx-auto py-2 my-3 ms-lg-2 justify-content-evenly align-items-center"
          >
            <div
              class="row align-items-center p-4 align-items-center justify-content-center ms-lg-2"
            >
              <h3 class="col-6 col-lg-12 text-center mb-lg-4">
                Consultas de <br />
                veterinario <br />a domicilio
              </h3>
              <img
                src="img/ser3.svg"
                alt=""
                class="col-6 col-lg-12 img-servicios-3 mx-auto"
              />
            </div>
          </section>
        </div>
        <div class="row bg-service-color rounded-5 align-items-center p-4 my-2">
          <h3>Peluquería</h3>
          <br />
          <div class="col-12 col-sm-3">
            <p><i class="bi bi-arrow-right fs-5">Cepilado</i></p>
            <p><i class="bi bi-arrow-right fs-5">Corte de uñas</i></p>
            <p><i class="bi bi-arrow-right fs-5">Recorte de pelo</i></p>
          </div>
          <div class="col-12 col-sm-3">
            <p><i class="bi bi-arrow-right fs-5">Limpieza de orejas</i></p>
            <p><i class="bi bi-arrow-right fs-5">Bañado</i></p>
            <p><i class="bi bi-arrow-right fs-5">Secado</i></p>
          </div>
          <div class="col-12 col-sm-6 d-flex">
            <img src="img/ser5.svg" alt="" class="w-75 mx-auto" />
          </div>
        </div>
      </div>
    </main>
    

  <?php include_once './footer.php' ;?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
