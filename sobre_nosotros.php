<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sobre nosotros</title>
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
              <a class="nav-link active" href="sobre_nosotros.php">Sobre<br />nosotros</a>
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
      <div class="container pt-4">
        <section class="row mb-4 p-3">
          <article class="col-12 col-lg-6 nuestra-historia order-lg-1">
            <div class="row mx-auto">
              <img src="img/garra_gris.svg" alt="" class="col-3 w-auto h-25" />
              <h1 class="col-8 align-self-center fs-2 mx-lg-auto">
                <b>Nuestra historia</b>
              </h1>
            </div>
            <p class="text-lg-end my-3">
              La veterinaria San Antón es una clínica veterinaria que se dedica
              al cuidado de animales, cuidados medicinales (rayos X, cirugías,
              vacunas, alimentación, farmacia, etc.), estéticos (baños,
              peluquería, etc.) y otros servicios (arriendo de jaulas,
              hospitalización, hotel, venta de productos).
            </p>
            <p class="text-lg-end">Fue creada por un
              grupo de médicos veterinarios que quería ofrecer la mejor medicina
              posible para perros, gatos y mascotas exóticas. Actualmente la
              clínica reside en la ciudad de Rosario provincia de Santa Fe,
              donde además cuenta con tres veterinarios titulados de
              prestigiosas universidades, los cuales prestan servicios a la
              clínica y están disponibles para consultas a domicilio.
            </p>
          </article>
          <div class="sobre-nosotros-1 col-12 col-lg-6 d-flex mt-4 mt-lg-0">
            <img
              src="img/sobre_nosotros_1.svg"
              alt=""
              class="img-fluid mx-auto"
            />
          </div>
        </section>
        <section class="row mb-5">
          <article class="col-12 col-lg-6 nuestro-equipo align-self-center">
            <h2 class="mb-3">Mira el equipo de San Antón</h2>
            <p class="mb-4">
              Trabajando en colaboración con los profesionales, cuidamos de las
              personas, de sus mascotas y de nuestra profesión, y hemos creado
              una cultura de calidez y pertenencia. No hay dos consultas
              iguales. Adoptamos y fomentamos ese espíritu independiente, al
              tiempo que apoyamos a los consultorios para que ofrezcan una
              atención excepcional a los pacientes y un servicio excelente a los
              clientes.
            </p>
            <a
              href=""
              class="bg-black rounded-pill text-light ver-equipo px-3 py-1 text-center"
              ><b>Ver equipo</b></a
            >
          </article>
          <div class="sobre-nosotros-2 col-12 col-lg-6 d-flex mt-4">
            <img
              src="img/sobre_nosotros_2.svg"
              alt=""
              class="img-fluid mx-auto"
            />
          </div>
        </section>
      </div>
    </main>

    <?php include './footer.php';?>
   
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
