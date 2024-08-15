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

$tamano_paginas = 10;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}


$empezar_desde = ($pagina - 1) * $tamano_paginas;

if (isset($_GET['searchServicios']) && !empty($_GET['searchServicios'])) {
  $filtro = $_GET['searchServicios'];
  $total_servicios = $admin->totalServiciosXBusqueda($filtro);
  if ($total_servicios == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $servicios = $admin->getServiciosXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_servicios = $admin->totalServicios();
  $servicios = $admin->getAllServicios($empezar_desde, $tamano_paginas);
  if (empty($servicios)) {
    $_SESSION['mensaje'] = 'No hay servicios registrados';
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
      <div class="d-flex justify-content-lg-between px-2">
        <h1 class="col-5 col-md-6">Servicios</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaServicioModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar servicio</span>
          </div>
        </button>
      </div>
      <hr />
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formSearchServicios" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Nombre o raza" aria-label="Buscar" name="searchServicios" value="<?= isset($_GET['searchServicios']) ? $_GET['searchServicios'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay servicios registrados -->
      <?php if ($servicios) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle mb-5">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Rol de personal a cargo</th>
                <th scope="col">Precio</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['msg-color']; ?> alert-dismissible fade show" role="alert">
                  <?php echo $_SESSION['mensaje']; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php
                unset($_SESSION['mensaje']);
                unset($_SESSION['msg-color']);
              }
              foreach ($servicios as $servicio) { ?>
                <tr>
                  <td><?php echo $servicio['nombre']; ?></td>
                  <td><?php echo $servicio['tipo']; ?></td>
                  <td><?php echo $servicio['rol']; ?></td>
                  <td>$ <?php echo $servicio['precio']; ?></td>
                  <td class="d-flex column-gap-3 ms-auto">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificaServicioModal" data-bs-id="<?= $servicio['servicio_id']; ?>">
                      <i class="bi bi-pencil-fill flex-grow-1"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaServicioModal" data-bs-id="<?= $servicio['servicio_id']; ?>">
                      <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

      <?php
      } else { ?>
        <div class="alert alert-warning" role="alert">
          <?php echo $_SESSION['mensaje'];
          unset($_SESSION['mensaje']);
          ?>
        </div>
      <?php } ?>
    </div>


    <footer class="footer mt-auto py-3 bg-light fixed-bottom">
      <nav aria-label="navigation-servicios">
        <ul class="pagination justify-content-center">
          <?php
          $total_paginas = ceil($total_servicios / $tamano_paginas);
          if (isset($_GET['searchServicios']) && !empty($_GET['searchServicios'])) {
            for ($i = 1; $i <= $total_paginas; $i++) {
              if ($i == $pagina) { ?>
                <li class="page-item active"><a class="page-link" href="?pagina=<?= $i; ?>&searchServicios=<?= $_GET['searchServicios']; ?>"><?= $i; ?></a></li>
              <?php } else { ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?= $i; ?>&searchServicios=<?= $_GET['searchServicios']; ?>"><?= $i; ?></a></li>
          <?php }
            }
          } else
            for ($i = 1; $i <= $total_paginas; $i++) {
              if ($i == $pagina) {
                echo '<li class="page-item active"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
              } else {
                echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '">' . $i . '</a></li>';
              }
            }
          ?>
        </ul>
      </nav>
    </footer>
  </main>

  <!-- Modals -->
  <?php include 'modales/altaServicioModal.html'; ?>
  <?php include 'modales/modificaServicioModal.html'; ?>
  <?php include 'modales/bajaServicioModal.html'; ?>

  <script>
    let modificaServicioModal = document.getElementById('modificaServicioModal');
    let bajaServicioModal = document.getElementById('bajaServicioModal');

    modificaServicioModal.addEventListener('hide.bs.modal', event => {
      modificaServicioModal.querySelector('.modal-body #servicio_id').value = '';
      modificaServicioModal.querySelector('.modal-body #rol_id').value = '';
      modificaServicioModal.querySelector('.modal-body #nombre').value = '';
      modificaServicioModal.querySelector('.modal-body #precioModificado').value = '';
      modificaServicioModal.querySelector('.modal-body #tipo').value = '';
    });

    modificaServicioModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget;
      let servicio_id = button.getAttribute('data-bs-id');

      let inputId = modificaServicioModal.querySelector('.modal-body #servicio_id');
      let inputNombre = modificaServicioModal.querySelector('.modal-body #nombre');
      let inputPrecio = modificaServicioModal.querySelector('.modal-body #precioModificado');
      let inputTipo = modificaServicioModal.querySelector('.modal-body #tipo');
      let inputPersonal = modificaServicioModal.querySelector('.modal-body #rol_id');

      let url = "getServicio.php";
      let data = new FormData();
      data.append('servicio_id', servicio_id);

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          inputId.value = data.servicio_id;
          inputNombre.value = data.nombre;
          inputPrecio.value = data.precio;
          inputTipo.value = data.tipo;
          inputPersonal.value = data.rol_id;
        });
    });

    bajaServicioModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget;
      let servicio_id = button.getAttribute('data-bs-id');
      console.log(servicio_id);
      bajaServicioModal.querySelector('.modal-footer #servicio_id').value = servicio_id;

    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>