<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" href="../img/logo.svg" />
    <title>Ingreso</title>
</head>
  <body class="min-vh-100">
<nav
      class="navbar sticky-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow"
    >
      <div class="container">

        <a class="navbar-brand" href="../index.php"
          ><img src="../img/logo.svg" alt="Veterinaria San Antón"
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
              <a class="nav-link" aria-current="page" href="../servicios.php">Servicios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="../contacto.php">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../sobre_nosotros.php">Sobre<br />nosotros</a>
            </li>
          </ul>
  
  <?php
          if (!isset($_SESSION['usuario'])) {
          echo 
          '<div class="registro row col-lg-3 mx-auto">
            <a href="./pagina-login/login.php" 
            class="btn btn1-bg-color rounded-pill col-12 col-lg-5 p-2 me-lg-1 mb-2 mb-lg-0 disabled">Ingresa</a>
            <a href="" class="btn btn2-bg-color rounded-pill p-2 col-12 col-lg-6">Registrate</a>
            
            </div>';
            
        } else {
                echo 'Usuario no registrado ';
        }

          ?>
          
        </div>
      </div>
    </nav>
    <main><section class="section-ing vh-75 align-self-center mt-4">
      <div class="registro">
        <h1>Hola!</h1>
        <h5>Bienvenido a la veterinaria San Antón!</h5>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"
              >Email address</label
            >
            <input
              type="email"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              name="email"
            />
            <div id="emailHelp" class="form-text">
              We'll never share your email with anyone else.
            </div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label"
              >Password</label
            >
            <input
              type="password"
              class="form-control"
              id="exampleInputPassword1"
              name="password"
            />
          </div>
          <div class="mb-3 form-check">
            <input
              type="checkbox"
              class="form-check-input"
              id="exampleCheck1"
            />
            <label class="form-check-label" for="exampleCheck1"
              >Check me out</label
            >
          </div>
          <button type="submit" class="btn btn-primary" name="enviar">Submit</button>
        </form>
      </div>
      <div class="imagen">
        <img src="../img/img_login.png" alt="" />
      </div>
    </section></main>

    <?php
    include_once("../inc/footer.php");
    ?>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>



    
  </body>
</html>
