<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="login.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" href="../img/logo.svg" />
  <title>Ingreso</title>
</head>

<body class="section-ing flex-column">
  <nav class="navbar fixed-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow">
    <div class="container">

      <a class="navbar-brand" href="../index.php"><img src="../img/logo.svg" alt="Veterinaria San Antón" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse row p-2" id="navbarNavDropdown">
        <ul class="navbar-nav mb-2 mb-lg-0 align-items-center justify-content-lg-evenly col-lg-9">
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
        <a href="./pagina-login/login.php"
          class="registro col-lg-3 mx-auto btn btn1-bg-color rounded-pill p-2 mb-2 mb-lg-0 disabled">Ingresa</a>
      </div>
    </div>
  </nav>
  <main class="px-2 px-md-0 row align-self-center rounded-5 mx-auto mt-4 mt-md-0 min-vh-100">
    <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-center gap-5 p-2">
      <h1>Hola!</h1>
      <h5>Bienvenido a la veterinaria San Antón!</h5>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="formulario gap-3" id="formulario">
        <?php if (isset($_SESSION['error'])) {  ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php } ?>
        <div class="mb-3">
          <label for="inputEmail" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" name="email" />
          <p id="emailError" class="text-danger"></p>
        </div>
        <div class="mb-4">
          <label for="inputPassword" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="inputPassword" name="password" />
            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
              <i class="bi bi-eye"></i>
            </span>
          </div>
          <p id="passwordError" class="text-danger"></p>
        </div>

        <button type="submit" class="btn btn-success w-100" name="enviar" id="submit-btn">Ingresar</button>
      </form>
    </div>
    <div class="imagen-login col-12 col-md-6 d-none d-lg-inline-block p-0">
      <img src="../img/img_login.png" alt="" class="h-100" />
    </div>
  </main>
  <!-- <script src="validacion_login.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <script>
    document.getElementById("togglePassword").addEventListener("click", function() {
      const passwordInput = document.getElementById("inputPassword");
      const icon = this.querySelector("i");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
      }
    });
  </script>


</body>

</html>