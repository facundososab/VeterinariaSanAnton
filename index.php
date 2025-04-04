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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="img/logo.svg" />
</head>

<body>
  <nav class="navbar sticky-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow" role="navigation">
    <div class="container">

      <a class="navbar-brand" href="index.php"><img src="./img/logo.svg" alt="Veterinaria San Antón" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse row mx-1" id="navbarNavDropdown">
        <ul class="navbar-nav mb-2 mb-lg-0 align-items-center justify-content-lg-evenly col-lg-9">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#servicios">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#sobrenosotros">Sobre<br />nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contacto">Contacto</a>
          </li>
        </ul>
        <a href="./pagina-login/login.php" class="registro btn btn1-bg-color rounded-pill col-lg-3 p-2 mb-2 mb-lg-0 mx-auto">Ingresa</a>

      </div>
    </div>
  </nav>
  <main class="pt-5 mx-2">
    <div class="container align-items-center justify-content-center bg-primary-color rounded-4 mb-5">
      <section class="row main-content">
        <article class="col-12 col-lg-6 order-lg-1 text-end d-flex flex-column align-items-end align-self-center px-4 pt-3">
          <h1 class="mt-3 display-1">Veterinaria<br />San Antón</h1>
          <p class="pb-1">Dirección de la veterinaria</p>
          <p class="pb-1">Teléfono de contacto</p>
          <a class="btn btn-danger rounded-pill fs-4 p-2 mt-3 d-md-none" href="tel:+543413531061">TENGO UNA EMERGENCIA</a>
          <p class="fs-5 my-4"><b>Lugar seguro para tu mascota</b></p>
          <div class="reseñas bg-third-color border border-black rounded-4 mb-4 w-50 align-items-center pt-2 ms-auto">
            <img src="./img/Avatars1.svg" alt="" class="col-12" />
            <p class="fs-5 text-center col-12">+100 Reseñas</p>
          </div>
          <div class="ubicacion d-flex align-items-center ms-auto justify-content-center mt-3">
            <img src="./img/garra_izq.svg" alt="" class="img-fluid" />
            <h5 class="mx-2 text-center">
              Ubicada en la ciudad de Rosario, Santa Fe
            </h5>
            <img src="./img/garra_der.svg" alt="" class="img-fluid" />
          </div>
        </article>
        <article class="img col-12 col-lg-6 d-flex">
          <img src="./img/dog 1.png" alt="Veterinaria San Antón" class="h-75 align-self-end img-fluid" />
        </article>
      </section>
    </div>
    <article class="py-5" id="servicios">
      <section id="servicios" class="container py-4">
        <!-- Hero Section -->
        <div class="bg-service-color rounded-4 p-4 p-md-5 mb-5">
          <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
              <h2 class="display-5 fw-bold service-text-color mb-3">
                ¿Te preocupa el estado de tu mascota?
              </h2>
              <p class="fs-4 service-text-color">
                Mirá los servicios que ofrecemos
              </p>
            </div>
            <div class="col-md-6 text-center">
              <img src="img/ser1.svg" alt="Veterinary Care" class="img-servicios-1 mx-auto img-fluid" />
            </div>
          </div>
        </div>

        <!-- Services Grid -->
        <div class="row g-4 mb-5">
          <!-- Sanidad -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition bg-service-color d-flex flex-column justify-evenly">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                  <div class="p-3 rounded-3 me-3">
                    <i class="bi bi-heart-pulse fs-4 service-text-color"></i>
                  </div>
                  <h3 class="h4 mb-0 service-text-color">Sanidad</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Diagnóstico exacto de enfermedades animales</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Controles sanitarios</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Análisis completos de sangre y orina</span>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Ecografía y radiología digital (rayos X)</span>
                  </li>
                </ul>
              </div>
              <!-- Image at the bottom of the card -->
              <div class="mb-4 text-center">
                <img src="img/ser2.svg" alt="Sanidad" class="mx-auto img-fluid" />
              </div>
            </div>
          </div>


          <!-- Hospitalización -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition bg-service-color">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                  <div class="p-3 rounded-3 me-3">
                    <i class="bi bi-hospital fs-4 service-text-color"></i>
                  </div>
                  <h3 class="h4 mb-0 service-text-color">Hospitalización</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Servicios de cuidado de animales</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Inmunización pasiva con suero</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Micro y macro terapia de llenado</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Rehabilitación y mantenimiento diario</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Transfusión de sangre</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Dietología</span>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Ayuda urgente</span>
                  </li>
                </ul>
                <div class="mt-4 text-center">
                  <img src="img/ser4.svg" alt="Hospitalización" class="mx-auto img-fluid" />
                </div>
              </div>
            </div>
          </div>

          <!-- Peluquería -->
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow-lg transition bg-service-color d-flex flex-column justify-evenly">
              <div class="card-body p-4 flex-grow-1">
                <div class="d-flex align-items-center mb-4">
                  <div class="p-3 rounded-3 me-3">
                    <i class="bi bi-scissors fs-4 service-text-color"></i>
                  </div>
                  <h3 class="h4 mb-0 service-text-color">Peluquería</h3>
                </div>
                <ul class="list-unstyled mb-0">
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Cepilado</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Corte de uñas</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Recorte de pelo</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Limpieza de orejas</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Bañado</span>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-arrow-right-short service-text-color me-2"></i>
                    <span class="service-text-color">Secado</span>
                  </li>
                </ul>
              </div>
              <!-- Image with margin above it -->
              <div class="mb-4 text-center">
                <img src="img/ser5.svg" alt="Peluquería" class="w-75 mx-auto img-fluid" />
              </div>
            </div>

          </div>
        </div>

        <!-- Home Service Card -->
        <div class="bg-primary-color rounded-4 p-4 p-md-5">
          <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
              <div class="d-flex align-items-center mb-4">
                <i class="bi bi-house-door fs-3 me-3 service-text-color"></i>
                <h3 class="h3 mb-0 service-text-color">Consultas de veterinario a domicilio</h3>
              </div>
              <p class="fs-5 service-text-color">
                Llevamos nuestros servicios veterinarios directamente a tu hogar para
                la comodidad de tu mascota
              </p>
            </div>
            <div class="col-md-6 text-center">
              <img src="img/ser3.svg" alt="Home Veterinary Service" class="img-servicios-3 mx-auto img-fluid" />
            </div>
          </div>
        </div>
      </section>
    </article>
    <article class="py-5" id="sobrenosotros">
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
            <img src="img/sobre_nosotros_1.svg" alt="" class="img-fluid mx-auto" />
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
            <a href="./404.php" class="bg-black rounded-pill text-light ver-equipo px-3 py-1 text-center"><b>Ver equipo</b></a>
          </article>
          <div class="sobre-nosotros-2 col-12 col-lg-6 d-flex mt-4">
            <img src="img/sobre_nosotros_2.svg" alt="" class="img-fluid mx-auto" />
          </div>
        </section>
      </div>
    </article>
    <article class="py-5 d-flex flex-grow-1 justify-content-center align-items-stretch" id="contacto">
      <div class="container d-flex mx-2">
        <section class="row flex-grow-1 bg-primary-color rounded-5">
          <div class="col-12 col-md-6 d-flex flex-column justify-content-between pt-4 ps-4">
            <h1 class="text-center m-5">Contactanos</h1>
            <img src="./img/img_contacto.svg" alt="Contacto" class="img-fluid">
          </div>
          <div class="col-12 col-md-6 py-4 px-5 d-flex justify-content-center align-items-center">
            <form action="https://formsubmit.co/9d131753bf0611193f7e0ba9d9998dd4" id="formulario" method="post" class="w-100">
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
      </>
  </main>

  <?php include_once('./footer.php'); ?>

  <script>
    window.onload = function() {
      document.getElementById("formulario").reset();
      document.getElementById("contactoForm").reset();
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>