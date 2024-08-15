<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} elseif ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$tamano_paginas = 8;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}

$empezar_desde = ($pagina - 1) * $tamano_paginas;

if (isset($_GET['searchInsumos']) && !empty($_GET['searchInsumos'])) {
  $filtro = $_GET['searchInsumos'];
  $total_insumos = $admin->totalInsumosXBusqueda($filtro);
  if ($total_insumos == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $insumos = $admin->getInsumosXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_insumos = $admin->totalInsumos();
  $insumos = $admin->getAllInsumos($empezar_desde, $tamano_paginas);
  if (empty($insumos)) {
    $_SESSION['mensaje'] = 'No hay insumos registrados';
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
        <h1 class="col-5 col-md-6">Insumos</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaInsumoModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar insumo</span>
          </div>
        </button>
      </div>
      <hr />
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formSearchInsumos" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Buscar por descripción" aria-label="Buscar" name="searchInsumos" value="<?= isset($_GET['searchInsumos']) ? $_GET['searchInsumos'] : ''; ?>">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay insumos registrados -->
      <?php if ($insumos) { ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Descripción</th>
                <th scope="col">Unidad de medida</th>
                <th scope="col">Cantidad</th>
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
              }
              foreach ($insumos as $insumo) { ?>
                <tr>
                  <td><?php echo $insumo['insumo_id']; ?></td>
                  <td><?php echo $insumo['descripcion']; ?></td>
                  <td><?php echo $insumo['unidad_medida']; ?></td>
                  <td><?php echo $insumo['cantidad']; ?></td>
                  <td class="d-flex column-gap-3 py-3">
                    <button type="button" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#modificaInsumoModal" data-bs-id="<?= $insumo['insumo_id'] ?>"><i class="bi bi-pencil-fill"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#bajaInsumoModal" data-bs-id="<?= $insumo['insumo_id'] ?>">
                      <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                  </td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>

      <?php } else { ?>
        <div class="alert alert-warning" role="alert">
        <?php
        echo $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
      } ?>
        </div>
  </main>

  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="navigation-insumos">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_insumos / $tamano_paginas);
        ?>

        <?php
        if (isset($_GET['searchInsumos']) && !empty($_GET['searchInsumos'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active">
                <a class="page-link" href="gestion_insumos.php?pagina=<?= $i ?>&searchInsumos=<?= $_GET['searchInsumos'] ?>"><?= $i ?></a>
              </li>
            <?php } else { ?>
              <li class="page-item">
                <a class="page-link" href="gestion_insumos.php?pagina=<?= $i ?>&searchInsumos=<?= $_GET['searchInsumos'] ?>"><?= $i ?></a>
              </li>
        <?php }
          }
        } else
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='gestion_insumos.php?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='gestion_insumos.php?pagina=$i'>$i</a></li>";
            }
          } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include_once 'modales/altaInsumoModal.html'; ?>
  <?php include_once 'modales/modificaInsumoModal.html'; ?>
  <?php include_once 'modales/bajaInsumoModal.html'; ?>

  <script>
    let editaModal = document.getElementById('modificaInsumoModal')
    let eliminaModal = document.getElementById('bajaInsumoModal')

    editaModal.addEventListener('hide.bs.modal', event => {
      editaModal.querySelector('.modal-body #descripcion').value = ''
      editaModal.querySelector('.modal-body #unidad_medida').value = ''
      editaModal.querySelector('.modal-body #cantidad').value = ''
    })

    editaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let insumo_id = button.getAttribute('data-bs-id')

      let inputId = editaModal.querySelector('.modal-body #insumo_id')
      let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
      let inputUnidadMedida = editaModal.querySelector('.modal-body #unidad_medida')
      let inputCantidad = editaModal.querySelector('.modal-body #cantidad')

      let url = './getInsumo.php'
      let data = new FormData()
      data.append('insumo_id', insumo_id)

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          inputId.value = data.insumo_id
          inputDescripcion.value = data.descripcion
          inputUnidadMedida.value = data.unidad_medida
          inputCantidad.value = data.cantidad

        })

    })

    eliminaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      eliminaModal.querySelector('.modal-footer #insumo_id').value = id
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>