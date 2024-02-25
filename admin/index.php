<?php

session_start();

if(!isset($_SESSION['rol_id'])){
    header('location: ../index.php');
} else {
    if ($_SESSION['rol_id'] != 1) {
        header('location: ../index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Veterinaria San Anton</title>
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
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" href="../img/logo.svg" />
  </head>
<body>
    <nav
      class="navbar sticky-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow"
    >
      <div class="container">

        <a class="navbar-brand" href="index.php"
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
        <div class="collapse navbar-collapse row mx-auto" id="navbarNavDropdown">
          <ul
            class="navbar-nav mb-2 mb-lg-0 align-items-center justify-content-lg-between col-lg-9"
          >
          <li class="nav-item">
              <a class="nav-link" aria-current="page" href="servicios.php">Turnos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="servicios.php">Mascotas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="servicios.php">Hospitalizacion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="servicios.php">Hospedaje</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="servicios.php">Insumos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="servicios.php">Clientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="servicios.php">Personal</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-3"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Ver perfil</a></li>
            <hr>
            <li><a class="dropdown-item text-danger" href="../pagina-login/cerrar_sesion.php">Cerrar sesion</a></li>
          </ul>
        </li>       
          </ul>         
        </div>
      </div>
    </nav>

    

 <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>

    
</body>
</html>