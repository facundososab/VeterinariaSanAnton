<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
  header('location: ../../index.php');
} else {
  if ($_SESSION['rol_id'] != 4) {
    header('location: ../../index.php');
  }
}

require_once '../clienteClass.php';
$cliente = new Cliente();
$cliente_id = $_SESSION['id'];

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
  $total_atenciones = $cliente->totalAtencionesXBusqueda($cliente_id, $filtro);
  if ($total_atenciones == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $atenciones = $cliente->getAtencionesXBusqueda($cliente_id, $filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_atenciones = $cliente->totalAtenciones($cliente_id);
  $atenciones = $cliente->getAllAtenciones($cliente_id, $empezar_desde, $tamano_paginas);
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
      <div class="row justify-content-lg-between px-2">
        <h1 class="col-5 col-md-6">Atenciones</h1>
        <nav class="navbar col-12 col-md-6">
          <div class="container-fluid justify-content-end">
            <form class="d-flex flex-grow-1 flex-md-grow-0" role="search" id="formSearchAtenciones" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
              <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="searchAtenciones" value="<?= isset($_GET['searchAtenciones']) ? $_GET['searchAtenciones'] : ''; ?>">
              <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </nav>
      </div>
      <hr />
      <!-- Verificar si hay atenciones registradas -->
      <?php if ($atenciones) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Mascota</th>
                <th scope="col">Servicio</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Atenciones a cargo</th>
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
                if ($atencion['mascota_fecha_muerte']) {
                  continue;
                }
              ?>
                <tr>
                  <td><?php echo $atencion['fecha_hora']; ?></td>
                  <td><?php echo ucfirst($atencion['mascota_nombre']) . ' - ' . ucfirst($atencion['raza']); ?></td>
                  <td><?php echo $atencion['servicio_nombre']; ?></td>
                  <td><?php echo ucfirst($atencion['titulo']); ?></td>
                  <td><?php echo ucfirst($atencion['descripcion']); ?></td>
                  <td><?php echo ucfirst($atencion['personal_nombre']) . ' ' . ucfirst($atencion['personal_apellido']); ?></td>
                  <td><?php echo $atencion['estado']; ?></td>
                  <td class="d-flex column-gap-3 py-3">
                    <button type="button" class="btn btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#bajaAtencionModal" data-bs-id="<?= $atencion['atencion_id'] ?>">
                      <i class="bi bi-x-lg"></i> Cancelar
                    </button>
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
                <a class="page-link" href="gestion_atenciones.php?pagina=<?= $i ?>&searchAtenciones=<?= $_GET['searchAtenciones'] ?>"><?= $i ?></a>
              </li>
            <?php } else { ?>
              <li class="page-item">
                <a class="page-link" href="gestion_atenciones.php?pagina=<?= $i ?>&searchAtenciones=<?= $_GET['searchAtenciones'] ?>"><?= $i ?></a>
              </li>
        <?php }
          }
        } else
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='gestion_atenciones.php?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='gestion_atenciones.php?pagina=$i'>$i</a></li>";
            }
          } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include './cancelaAtencionModal.html'; ?>

  <script>
    let cancelaAtencionModal = document.getElementById('bajaAtencionModal');


    cancelaAtencionModal.addEventListener('show.bs.modal', event => {
      let button = event.relatedTarget;
      let id = button.getAttribute('data-bs-id');
      cancelaAtencionModal.querySelector('.modal-body #atencion_id').value = id;
      console.log(id);
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>


</body>

</html>