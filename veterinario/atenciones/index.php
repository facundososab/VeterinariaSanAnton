<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$vet_id = $_SESSION['id'];

$tamano_paginas = 8;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$atenciones = null;

if (isset($_GET['searchAtenciones']) && !empty($_GET['searchAtenciones'])) {
  $filtro = $_GET['searchAtenciones'];
  $total_atenciones = $vet->totalAtencionesXBusqueda($vet_id, $filtro);
  if ($total_atenciones == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $atenciones = $vet->getAtencionesXBusqueda($vet_id, $filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_atenciones = $vet->totalAtenciones($vet_id);
  $atenciones = $vet->getAllAtenciones($vet_id, $empezar_desde, $tamano_paginas);
  if (empty($atenciones)) {
    $_SESSION['mensaje'] = 'No hay atenciones registradas';
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
      <div class="d-flex justify-content-lg-between px-2">
        <h1 class="col-5 col-md-6">Mis atenciones</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaAtencionModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar atención</span>
          </div>
        </button>
      </div>
      <hr />
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formSearchAtenciones" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="searchAtenciones" value="<?= isset($_GET['searchAtenciones']) ? $_GET['searchAtenciones'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay atenciones registradas -->
      <?php if ($atenciones) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Mascota</th>
                <th scope="col">Dueño</th>
                <th scope="col">Servicio</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estado</th>
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
              foreach ($atenciones as $atencion) {
              ?>
                <tr>
                  <td><?php echo $atencion['fecha_hora']; ?></td>
                  <td><?php echo ucfirst($atencion['mascota_nombre']) . ' - ' . ucfirst($atencion['raza']); ?></td>
                  <td><?php echo ucfirst($atencion['cliente_nombre']) . ' ' . ucfirst($atencion['cliente_apellido']); ?></td>
                  <td><?php echo $atencion['servicio_nombre']; ?></td>
                  <td><?php echo ucfirst($atencion['titulo']); ?></td>
                  <td><?php echo ucfirst($atencion['descripcion']); ?></td>
                  <td><?php echo $atencion['estado']; ?></td>
                  <td>
                    <div class="row row-gap-2 column-gap-1 mx-1 justify-content-center">
                      <button type="button" class="btn btn-info col-12 col-md-10 mx-1" data-bs-toggle="modal" data-bs-target="#actualizaEstadoAtencionModal" data-bs-id="<?= $atencion['atencion_id']; ?>" data-bs-estado="<?= $atencion['estado']; ?>">
                        <i class="bi bi-arrow-repeat"></i> Actualizar estado
                      </button>
                      <button type="button" class="btn btn-warning col-md-5 col-12" data-bs-toggle="modal" data-bs-target="#modificaAtencionModal" data-bs-id="<?= $atencion['atencion_id']; ?>">
                        <i class="bi bi-pencil-fill"></i> Editar
                      </button>
                      <button type="button" class="btn btn-danger col-md-5 col-12" data-bs-toggle="modal" data-bs-target="#bajaAtencionModal" data-bs-id="<?= $atencion['atencion_id']; ?>">
                        <i class=" bi bi-trash-fill"></i>Eliminar
                      </button>
                    </div>
                  </td>
                <?php } ?>
            </tbody>
          </table>
        </div>
      <?php
      } else { ?>
        <div class="alert alert-warning" role="alert">
          <?php echo $_SESSION['mensaje'];
          unset($_SESSION['mensaje']); ?>
        </div>
      <?php } ?>
    </div>
  </main>

  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="Page navigation atenciones">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_atenciones / $tamano_paginas);

        if (isset($_GET['searchAtenciones']) && !empty($_GET['searchAtenciones'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active">
                <a class="page-link" href="gpagina=<?= $i ?>&searchAtenciones=<?= $_GET['searchAtenciones'] ?>"><?= $i ?></a>
              </li>
            <?php } else { ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?= $i ?>&searchAtenciones=<?= $_GET['searchAtenciones'] ?>"><?= $i ?></a>
              </li>
        <?php }
          }
        } else
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='?pagina=$i'>$i</a></li>";
            }
          } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include 'altaAtencionModal.php'; ?>
  <?php include 'modificaAtencionModal.php'; ?>
  <?php include 'bajaAtencionModal.html'; ?>
  <?php include 'actualizaEstadoAtencionModal.html'; ?>

  <script>
    let editaModal = document.getElementById('modificaAtencionModal');
    let bajaModal = document.getElementById('bajaAtencionModal');
    let actualizaEstadoModal = document.getElementById('actualizaEstadoAtencionModal');

    editaModal.addEventListener('hide.bs.modal', event => {

      editaModal.querySelector('.modal-body #atencion_id').value = '';
      editaModal.querySelector('.modal-body #fecha_hora_modifica').value = '';
      editaModal.querySelector('.modal-body #titulo_modifica').value = '';
      editaModal.querySelector('.modal-body #descripcion_modifica').value = '';
      editaModal.querySelector('.modal-body #personal_id_modifica').value = '';
      editaModal.querySelector('.modal-body #servicio_id_modifica').value = '';
      editaModal.querySelector('.modal-body #mascota_id_modifica').value = '';
    });

    editaModal.addEventListener('show.bs.modal', event => {
      let button = event.relatedTarget;
      let id = button.getAttribute('data-bs-id');

      let atencion_id = editaModal.querySelector('.modal-body #atencion_id');
      let fecha_hora = editaModal.querySelector('.modal-body #fecha_hora_modifica');
      let titulo = editaModal.querySelector('.modal-body #titulo_modifica');
      let descripcion = editaModal.querySelector('.modal-body #descripcion_modifica');
      let personal_id = editaModal.querySelector('.modal-body #personal_id_modifica');
      let servicio_id = editaModal.querySelector('.modal-body #servicio_id_modifica');
      let mascota_id = editaModal.querySelector('.modal-body #mascota_id_modifica');
      let url = './getAtencion.php';
      let data = new FormData();
      data.append('atencion_id', id);

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          atencion_id.value = data.atencion_id;
          fecha_hora.value = data.fecha_hora;
          titulo.value = data.titulo;
          descripcion.value = data.descripcion;
          servicio_id.value = data.servicio_id;
          mascota_id.value = data.mascota_id;
          personal_id.innerHTML = `<option value="${data.personal_id}">${data.personal_nombre} ${data.personal_apellido}</option>`
        })
    });

    bajaModal.addEventListener('show.bs.modal', event => {
      let button = event.relatedTarget;
      let id = button.getAttribute('data-bs-id');
      bajaModal.querySelector('.modal-body #atencion_id').value = id;
    });

    actualizaEstadoModal.addEventListener('show.bs.modal', event => {
      let button = event.relatedTarget;
      let id = button.getAttribute('data-bs-id');
      actualizaEstadoModal.querySelector('.modal-body #atencion_id').value = id;
      actualizaEstadoModal.querySelector('.modal-body #estado').value = button.getAttribute('data-bs-estado');
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>


</body>

</html>