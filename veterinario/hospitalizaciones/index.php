<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
  header('location: ../../index.php');
} else {
  if ($_SESSION['rol_id'] != 2) {
    header('location: ../../index.php');
  }
}

require_once '../vetClass.php';
$vet = new Veterinario();

$tamano_paginas = 8;

if (isset($_GET['pagina'])) {
  $pagina = $_GET['pagina'];
} else {
  $pagina = 1;
}

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$hospitalizaciones = null;

if (isset($_GET['searchHospitalizacion']) && !empty($_GET['searchHospitalizacion'])) {
  $filtro = $_GET['searchHospitalizacion'];
  $total_hospitalizaciones = $vet->totalHospitalizacionesXBusqueda($filtro);
  if ($total_hospitalizaciones == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $hospitalizaciones = $vet->getHospitalizacionesXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_hospitalizaciones = $vet->totalHospitalizaciones();
  $hospitalizaciones = $vet->getAllHospitalizaciones($empezar_desde, $tamano_paginas);
  if (empty($hospitalizaciones)) {
    $_SESSION['mensaje'] = 'No hay hospitalizaciones registradas';
    $_SESSION['msg-color'] = 'warning';
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<?php include_once '../head.html'; ?>

<body>
  <?php include_once '../header.html'; ?>

  <main class="pt-5">
    <div class="container">
      <div class="row justify-content-lg-between px-2">
        <h1 class="col-12 col-md-6">Hospitalizaciones</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-12 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaHospitalizacionModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar hospitalización</span>
          </div>
        </button>
      </div>
      <hr>
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formSearchHospitalizacion" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Mascota o personal responsable" aria-label="Buscar" name="searchHospitalizacion" value="<?= isset($_GET['searchHospitalizacion']) ? $_GET['searchHospitalizacion'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay hospitalizaciones registradas -->
      <?php if ($hospitalizaciones) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle mb-5">
            <thead>
              <tr>
                <th scope="col">Mascota</th>
                <th scope="col">Fecha de ingreso</th>
                <th scope="col">Motivo</th>
                <th scope="col">Fecha de alta</th>
                <th scope="col">Observaciones</th>
                <th scope="col">Personal responsable</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['msg-color']; ?> alert-dismissible fade show" role="alert">
                  <?= $_SESSION['mensaje']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php
                unset($_SESSION['msg-color']);
                unset($_SESSION['mensaje']);
              } ?>
              <?php foreach ($hospitalizaciones as $hospitalizacion) : ?>
                <tr>
                  <td><?php echo ucfirst($hospitalizacion['mascota_nombre']); ?></td>
                  <td><?php echo $hospitalizacion['fecha_hora_ingreso']; ?></td>
                  <td><?php echo $hospitalizacion['motivo']; ?></td>
                  <td><?php if (!$hospitalizacion['fecha_hora_alta']) {
                        echo '- - - - -';
                      } else {
                        echo $hospitalizacion['fecha_hora_alta'];
                      } ?></td>
                  <td><?php if (!$hospitalizacion['observaciones']) {
                        echo '- - - - -';
                      } else {
                        echo $hospitalizacion['observaciones'];
                      } ?></td>
                  <td><?php echo ucfirst($hospitalizacion['personal_nombre']) . ' ' . ucfirst($hospitalizacion['personal_apellido']); ?></td>
                  <td class="d-flex gap-2">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificaHospitalizacionModal" data-bs-id="<?php echo $hospitalizacion['hospitalizacion_id']; ?>">
                      <i class="bi bi bi-pencil-fill"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaHospitalizacionModal" data-bs-id="<?php echo $hospitalizacion['hospitalizacion_id']; ?>">
                      <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                    <button type="button" class="btn btn-info" <?php if (isset($hospitalizacion['fecha_hora_alta'])) {
                                                                  echo 'disabled';
                                                                } ?> data-bs-toggle="modal" data-bs-target="#altaMedicaHospitalizacionModal" data-bs-id="<?php echo $hospitalizacion['hospitalizacion_id']; ?>">
                      <i class="bi bi-check-circle-fill"></i> Dar de alta
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php } else { ?>
        <div class="alert alert-warning" role="alert">
          <?php echo $_SESSION['mensaje'];
          unset($_SESSION['mensaje']); ?>
        </div>
      <?php } ?>
  </main>

  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="navigation-hospitalizaciones">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_hospitalizaciones / $tamano_paginas);

        if (isset($_GET['searchHospitalizacion']) && !empty($_GET['searchHospitalizacion'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active"><a class="page-link" href="?pagina=<?= $i ?>&searchHospitalizacion=<?= $_GET['searchHospitalizacion'] ?>"><?= $i ?></a></li>
            <?php } else { ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?= $i ?>&searchHospitalizacion=<?= $_GET['searchHospitalizacion'] ?>"><?= $i ?></a></li>
        <?php }
          }
        } else {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='?pagina=$i'>$i</a></li>";
            }
          }
        } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include_once 'altaHospitalizacionModal.php'; ?>
  <?php include_once 'modificaHospitalizacionModal.php'; ?>
  <?php include_once 'bajaHospitalizacionModal.html'; ?>
  <?php include_once 'darAltaMedicaHospitalizacionModal.html'; ?>

  <script>
    let modificaHospitalizacionModal = document.getElementById('modificaHospitalizacionModal');
    let bajaHospitalizacionModal = document.getElementById('bajaHospitalizacionModal');
    let altaMedicaHospitalizacionModal = document.getElementById('altaMedicaHospitalizacionModal');

    modificaHospitalizacionModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let hospitalizacion_id = document.getElementById('hospitalizacion_id')
      let fecha_hora_ingreso_modifica = document.getElementById('fecha_hora_ingreso_modifica')
      let motivo = document.getElementById('motivo_modifica')
      let mascota_id = document.getElementById('mascota_id_modifica')

      let url = './getHospitalizacion.php';
      let data = new FormData();
      data.append('hospitalizacion_id', id);
      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          hospitalizacion_id.value = data.hospitalizacion_id
          fecha_hora_ingreso_modifica.value = data.fecha_hora_ingreso
          motivo.value = data.motivo
          mascota_id.value = data.mascota_id
        })
        .catch(error => console.error('Error:', error));
    })

    modificaHospitalizacionModal.addEventListener('hide.bs.modal', event => {
      let hospitalizacion_id = document.getElementById('hospitalizacion_id')
      let fecha_hora_ingreso_modifica = document.getElementById('fecha_hora_ingreso_modifica')
      let motivo = document.getElementById('motivo_modifica')

      hospitalizacion_id.value = ''
      fecha_hora_ingreso_modifica.value = ''
      motivo.value = ''
    })

    bajaHospitalizacionModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let hospitalizacion_id = document.getElementById('hospitalizacion_id_baja')
      hospitalizacion_id.value = id
    })

    bajaHospitalizacionModal.addEventListener('hide.bs.modal', event => {
      let hospitalizacion_id = document.getElementById('hospitalizacion_id_baja')
      hospitalizacion_id.value = ''
    })

    altaMedicaHospitalizacionModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let hospitalizacion_id = document.getElementById('hospitalizacion_id_alta_medica')
      hospitalizacion_id.value = id
    })

    altaMedicaHospitalizacionModal.addEventListener('hide.bs.modal', event => {
      let hospitalizacion_id = document.getElementById('hospitalizacion_id_alta_medica')
      let observaciones = document.getElementById('observaciones_alta_medica')

      hospitalizacion_id.value = ''
      observaciones.value = ''
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>