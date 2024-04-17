<?php

session_start();
if(!isset($_SESSION['usuario'])){
    header('Location: index.php');
}elseif($_SESSION['rol_id'] != 1){
    header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$mascotas = $admin->getAllMascotas();

?>

<!DOCTYPE html>
<html lang="en">
  <?php include_once 'head.html';?>
  <body>
    <?php include_once 'header.html';?>
    <main class="pt-5">
    <div class="container">    
        <div class="d-flex justify-content-lg-between">
          <h1 class="col-12 col-md-6">Mascotas</h1>
            <!-- Button trigger modal -->
            <button
              type="button"
              class="btn btn-success col-12 col-md-2"
              data-bs-toggle="modal"
              data-bs-target="#altaMascotaModal"
            >
            <i class="bi bi-plus-circle-fill pe-1"></i> 
              Registrar mascota
            </button>
        </div>
        <hr />
        <!-- Verificar si hay mascotas registradas -->
        <?php if ($mascotas) { ?>
          <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Raza</th>
              <th scope="col">Color</th>
              <th scope="col">Fecha de nacimiento</th>
              <th scope="col">Cliente</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($_SESSION['mensaje'])) { ?>
              <div class="alert alert-<?= $_SESSION['msg-color']; ?> alert-dismissible fade show" role="alert">
                  <?= $_SESSION['mensaje'];?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php
                unset($_SESSION['msg-color']);
                unset($_SESSION['mensaje']);
            } ?>
            <?php foreach ($mascotas as $mascota) { 
                $cliente= $admin->getCliente($mascota['cliente_id']);
                $cliente_mail = $cliente['email'];
                $cliente_nombre = $cliente['nombre'];
                $cliente_apellido = $cliente['apellido'];
                ?>
              <tr>
                <td><?= ucfirst($mascota['nombre']); ?></td>
                <td><?= ucfirst($mascota['raza']); ?></td>
                <td><?= ucfirst($mascota['color']); ?></td>
                <td><?= $mascota['fecha_nac']; ?></td>
                <td><span><?= ucfirst($cliente_nombre). ' ' . ucfirst($cliente_apellido) ?> </span><br><span><?='(' . $cliente_mail . ')'?></td>
                <td class="d-flex column-gap-3 align-items-center h-100">
                  <a
                    href="editar_mascota.php?id=<?= $mascota['mascota_id']; ?>"
                    class="btn btn-warning"
                  >
                    <i class="bi bi-pencil-fill"></i>
                    Editar
                  </a>
                  <a
                    href="borrar_mascota.php?id=<?= $mascota['mascota_id']; ?>"
                    class="btn btn-danger"
                  >
                    <i class="bi bi-trash-fill"></i>
                    Eliminar
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php } else { ?>
          <div class="alert alert-warning" role="alert">
            No hay mascotas registradas
          </div>
        <?php } ?>
    </div>
    </main>

    <!-- Modales -->
    <?php include_once './modales/altaMascotaModal.php';?>
    <?php include_once './modales/modificaMascotaModal.html';?>
    <?php include_once './modales/bajaMascotaModal.html';?>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>


  </body>
</html>
    
