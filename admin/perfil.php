<?php 

session_start();

if(!isset($_SESSION['usuario'])){
  header('Location: index.php');
}else if($_SESSION['rol_id'] != 1){
    header('Location: index.php');
}

require_once './adminClass.php';
$admin = new Admin();

$adminInfo = $admin->getAdminInfo();

$admin_nombre = $adminInfo['nombre'];
$admin_apellido = $adminInfo['apellido'];
$admin_email = $adminInfo['email'];
$admin_clave = $adminInfo['clave'];



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <title>Editar Perfil</title>

  </head>
  <body class="min-vh-100">
    <header class="navbar fixed-top border-bottom p-2 bg-primary">
      <a href="./index.php" class="btn btn-primary border" type="submit" name="btn-volver">
          <i class="bi bi-arrow-left fw-bold"></i>
        </a>
    </header>
    <main class="d-flex flex-column justify-content-center align-items-center min-vh-100 w-100">
      <h1 class="aling-self-start my-5">Editar Perfil</h1>
      <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['msg-color'] ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['mensaje'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['msg-color']);
        }
       ?>

        <form action="actualiza_perfil.php" method="POST" class="formulario-perfil min-vh-75 p-4" id="formulario_perfil">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              name="nombre"
              value="<?=$admin_nombre?>"
            />
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input
              type="text"
              class="form-control"
              id="apellido"
              name="apellido"
              value="<?=$admin_apellido?>"
            />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              value="<?=$admin_email?>"
            />
          </div>
          <div class="mb-3">
            <a href="cambiaContraseña.php">Cambiar contraseña aquí.</a>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar</button>
    </main>
    <script src="validacion_formularios.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
