<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
  header('location: ../index.php');
} else {
  if ($_SESSION['rol_id'] != 1) {
    header('location: ../index.php');
  }
}

require_once 'adminClass.php';
$admin = new Admin();

$tamano_paginas = 8;

if (isset($_GET['pagina'])) {
  $pagina = $_GET['pagina'];
} else {
  $pagina = 1;
}

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$hospedajes = null;

if (isset($_GET['searchHospedaje']) && !empty($_GET['searchHospedaje'])) {
  $filtro = $_GET['searchHospedaje'];
  $total_hospedajes = $admin->totalHospedajesXBusqueda($filtro);
  if ($total_hospedajes == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $hospedajes = $admin->getHospedajesXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_hospedajes = $admin->totalHospedajes();
  $hospedajes = $admin->getAllHospedajes($empezar_desde, $tamano_paginas);
  if (empty($hospedajes)) {
    $_SESSION['mensaje'] = 'No hay hospedajes registrados';
    $_SESSION['msg-color'] = 'warning';
  }
}

?>

<!DOCTYPE html>
<html lang="es">
<?php include_once 'head.html'; ?>

<body>
  <?php include_once 'header.html'; ?>

  <main class="pt-5">
    <div class="container">
      <div class="row justify-content-lg-between px-2">
        <h1 class="col-12 col-md-6">Hotelería</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-12 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaHospedajeModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar hospedaje</span>
          </div>
        </button>
      </div>
      <hr>
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formSearchHospedaje" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Mascota o personal responsable" aria-label="Buscar" name="searchHospedaje" value="<?= isset($_GET['searchHospedaje']) ? $_GET['searchHospedaje'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay hospedajees registradas -->
      <?php if ($hospedajes) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle mb-5">
            <thead>
              <tr>
                <th scope="col">Mascota</th>
                <th scope="col">Raza</th>
                <th scope="col">Fecha de ingreso</th>
                <th scope="col">Fecha de salida</th>
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
              <?php foreach ($hospedajes as $hospedaje) : ?>
                <tr>
                  <td><?php echo ucfirst($hospedaje['mascota_nombre']); ?></td>
                  <td><?php echo ucfirst($hospedaje['raza']); ?></td>
                  <td><?php echo $hospedaje['fecha_hora_ingreso']; ?></td>
                  <td><?php if (!$hospedaje['fecha_hora_salida']) {
                        echo '- - - - -';
                      } else {
                        echo $hospedaje['fecha_hora_salida'];
                      } ?></td>
                  <td><?php echo ucfirst($hospedaje['personal_nombre']) . ' ' . ucfirst($hospedaje['personal_apellido']); ?></td>
                  <td class="d-flex gap-2">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificaHospedajeModal" data-bs-id="<?php echo $hospedaje['hospedaje_id']; ?>">
                      <i class="bi bi bi-pencil-fill"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaHospedajeModal" data-bs-id="<?php echo $hospedaje['hospedaje_id']; ?>">
                      <i class="bi bi-trash-fill"></i> Eliminar
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
    <nav aria-label="navigation-hoteleria">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_hospedajes / $tamano_paginas);

        if (isset($_GET['searchHospedaje']) && !empty($_GET['searchHospedaje'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='gestion_hoteleria.php?searchHospedaje=" . $_GET['searchHospedaje'] . "&pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='gestion_hoteleria.php?searchHospedaje=" . $_GET['searchHospedaje'] . "&pagina=$i'>$i</a></li>";
            }
          }
        } else {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='gestion_hoteleria.php?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='gestion_hoteleria.php?pagina=$i'>$i</a></li>";
            }
          }
        } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include_once 'modales/altaHospedajeModal.php'; ?>
  <?php include_once 'modales/modificahospedajeModal.php'; ?>
  <?php include_once 'modales/bajaHospedajeModal.html'; ?>

  <script>
    let modificahospedajeModal = document.getElementById('modificaHospedajeModal');
    let bajaHospedajeModal = document.getElementById('bajaHospedajeModal');

    modificaHospedajeModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let hospedaje_id = document.getElementById('hospedaje_id')
      let fecha_hora_ingreso_modifica = document.getElementById('fecha_hora_ingreso_modifica')
      let fecha_hora_salida_modifica = document.getElementById('fecha_hora_salida_modifica')
      let mascota_id_modifica = document.getElementById('mascota_id_modifica')
      let personal_id_modifica = document.getElementById('personal_id_modifica')


      let url = './getHospedaje.php';
      let data = new FormData();
      data.append('hospedaje_id', id);
      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          console.log(data)
          hospedaje_id.value = data.hospedaje_id
          fecha_hora_ingreso_modifica.value = data.fecha_hora_ingreso
          fecha_hora_salida_modifica.value = data.fecha_hora_salida
          mascota_id_modifica.value = data.mascota_id
          personal_id_modifica.value = data.personal_id
        })
        .catch(error => console.error('Error:', error));
    })

    modificaHospedajeModal.addEventListener('hide.bs.modal', event => {
      let hospedaje_id = document.getElementById('hospedaje_id')
      let fecha_hora_ingreso_modifica = document.getElementById('fecha_hora_ingreso_modifica')
      let fecha_hora_salida_modifica = document.getElementById('fecha_hora_salida_modifica')
      let mascota_id_modifica = document.getElementById('mascota_id_modifica')
      let personal_id_modifica = document.getElementById('personal_id_modifica')

      hospedaje_id.value = ''
      fecha_hora_ingreso_modifica.value = ''
      fecha_hora_salida_modifica.value = ''
      mascota_id_modifica.value = ''
      personal_id_modifica.value = ''
    })

    bajaHospedajeModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let hospedaje_id = document.getElementById('hospedaje_id_baja')
      hospedaje_id.value = id
    })

    bajaHospedajeModal.addEventListener('hide.bs.modal', event => {
      let hospedaje_id = document.getElementById('hospedaje_id_baja')
      hospedaje_id.value = ''
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>