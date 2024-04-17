<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

if(isset($_POST['btn-cambiar'])){
  $nueva_clave = $_POST['nueva_clave'];
  $confirma_clave = $_POST['confirma_clave'];

  if($nueva_clave == $confirma_clave){
    try {
      $claveCifrada = password_hash($nueva_clave, PASSWORD_DEFAULT, ['cost' => 12]);
      if ($admin->updateAdminPassword($claveCifrada)) {
        $_SESSION['mensaje'] = 'Contraseña cambiada con éxito';
        $_SESSION['msg-color'] = 'success';
      }
    } catch (Exception $e) {
      $_SESSION['mensaje'] = 'Error al cambiar contraseña: ' . $e->getMessage();
      $_SESSION['msg-color'] = 'danger';
    }
  }else{
    $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
    $_SESSION['msg-color'] = 'danger';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambio Contraseña Administrador</title>
  <?php include_once 'head.html';?>
</head>
<body>

<header class="navbar fixed-top border-bottom p-2 bg-primary">
      <a href="./perfil.php" class="btn btn-primary border" type="submit" name="btn-volver">
          <i class="bi bi-arrow-left fw-bold"></i>
        </a>
    </header>
    <main class="d-flex flex-column justify-content-center align-items-center min-vh-100 w-100">
      <h1 class="aling-self
      -start my-5">Cambiar Contraseña</h1>
      <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['msg-color']; ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['mensaje'];?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <?php
        unset($_SESSION['msg-color']);
        unset($_SESSION['mensaje']);
      } ?>
      <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" class="col-12 col-md-6">
        <div class="mb-3">
          <label for="nueva_clave" class="form-label">Nueva Contraseña</label>
          <input type="password" class="form-control" id="nueva_clave" name="nueva_clave" required>
        </div>
        <div class="mb-3">
          <label for="confirma_clave" class="form-label
          ">Confirma Contraseña</label>
          <input type="password" class="form-control" id="confirma_clave" name="confirma_clave" required>
        </div>
        <button type="submit" class="btn btn-primary" name="btn-cambiar">Cambiar</button>
      </form>
    </main>

  

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>

</body>
</html>