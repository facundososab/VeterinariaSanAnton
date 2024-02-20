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
    <?php
    include 'nav.php';

    echo '<main>
      <div class="container pt-4">
        <section class="row mb-4 p-3">
          <article class="col-12 col-lg-6 nuestra-historia order-lg-1">
            <div class="row mx-auto">
              <img src="img/garra_gris.svg" alt="" class="col-3 w-auto h-25" />
              <h1 class="col-9 align-self-center display-5 mx-lg-auto">
                <b>Nuestra historia</b>
              </h1>
            </div>
            <p class="text-lg-end my-3 my-lg-0">
              La veterinaria San Antón es una clínica veterinaria que se dedica
              al cuidado de animales, cuidados medicinales (rayos X, cirugías,
              vacunas, alimentación, farmacia, etc.), estéticos (baños,
              peluquería, etc.) y otros servicios (arriendo de jaulas,
              hospitalización, hotel, venta de productos). Fue creada por un
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
    </main>';

    include 'footer.php';

    ?>
   
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
