<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';
$pelu = new Peluquero();

$tamano_paginas = 8;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}


$empezar_desde = ($pagina - 1) * $tamano_paginas;

$clientes = null;

if (isset($_GET['searchCliente']) && !empty($_GET['searchCliente'])) {
  $filtro = $_GET['searchCliente'];
  $total_clientes = $pelu->totalClientesXBusqueda($filtro);
  if ($total_clientes == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $clientes = $pelu->getClientesXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_clientes = $pelu->totalClientes();
  if ($total_clientes == 0) {
    $_SESSION['mensaje'] = 'No hay clientes registrados';
    $_SESSION['msg-color'] = 'warning';
    return;
  }
  $clientes = $pelu->getAllClientes($empezar_desde, $tamano_paginas);
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once '../head.html'; ?>

<body>
  <?php include_once '../header.html'; ?>
  <main class="pt-5">
    <div class="container">
      <div class="container">
        <div class="d-flex justify-content-lg-between px-2">
          <h1 class="col-5 col-md-6">Clientes</h1>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaClienteModal">
            <div class="d-flex align-items-center justify-content-center">
              <i class="bi bi-plus-circle-fill pe-1"></i>
              <span>Registrar cliente</span>
            </div>
          </button>
        </div>
        <hr />
        <nav class="navbar">
          <div class="container-fluid justify-content-end">
            <form class="d-flex" role="search" id="formSearchCliente" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
              <input class="form-control me-2" type="search" placeholder="Nombre, apellido o email" aria-label="Buscar" name="searchCliente" value="<?= isset($_GET['searchCliente']) ? $_GET['searchCliente'] : ''; ?>">
              <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </nav>
        <!-- Verificar si hay clientes registrados -->
        <?php if ($clientes) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Email</th>
                  <th scope="col">Teléfono</th>
                  <th scope="col">Ciudad</th>
                  <th scope="col">Dirección</th>
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
                <?php foreach ($clientes as $cliente) { ?>
                  <tr>
                    <td><?= ucfirst($cliente['nombre']); ?></td>
                    <td><?= ucfirst($cliente['apellido']); ?></td>
                    <td><?= $cliente['email']; ?></td>
                    <td><?= $cliente['telefono']; ?></td>
                    <td><?= ucfirst($cliente['ciudad']); ?></td>
                    <td><?= ucfirst($cliente['direccion']); ?></td>
                    <td class="d-flex column-gap-3">
                      <button href="#" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#modificaClienteModal" data-bs-id="<?= $cliente['cliente_id']; ?>"><i class="bi bi bi-pencil-fill"></i> Editar
                      </button>
                      <button href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaClienteModal" data-bs-id="<?= $cliente['cliente_id']; ?>"><i class="bi bi-trash"></i> Eliminar
                      </button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        <?php } else { ?>
          <div class="alert alert-warning" role="alert">
            <?php echo $_SESSION['mensaje'];
            unset($_SESSION['mensaje']); ?>
          </div>
        <?php } ?>
      </div>
  </main>
  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="Page navigation clientes">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_clientes / $tamano_paginas);
        if (isset($_GET['searchCliente']) && !empty($_GET['searchCliente'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active"><a class="page-link" href="?pagina=<?= $i ?>&searchCliente=<?= $_GET['searchCliente'] ?>"><?= $i ?></a></li>
            <?php } else { ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?= $i ?>&searchCliente=<?= $_GET['searchCliente'] ?>"><?= $i ?></a></li>
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
        }
        ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include 'altaClienteModal.html'; ?>
  <?php include 'modificaClienteModal.html'; ?>
  <?php include 'bajaClienteModal.html'; ?>

  <script>
    let editaModal = document.getElementById('modificaClienteModal')
    let eliminaModal = document.getElementById('bajaClienteModal')

    editaModal.addEventListener('hide.bs.modal', event => {
      editaModal.querySelector('.modal-body #cliente_id').value = ""
      editaModal.querySelector('.modal-body #nombre').value = ""
      editaModal.querySelector('.modal-body #apellido').value = ""
      editaModal.querySelector('.modal-body #email').value = ""
      editaModal.querySelector('.modal-body #telefono').value = ""
      editaModal.querySelector('.modal-body #ciudad').value = ""
      editaModal.querySelector('.modal-body #direccion').value = ""
    })

    editaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')

      let inputId = editaModal.querySelector('.modal-body #cliente_id')
      let inputNombre = editaModal.querySelector('.modal-body #nombre')
      let inputApellido = editaModal.querySelector('.modal-body #apellido')
      let inputEmail = editaModal.querySelector('.modal-body #email')
      let inputTelefono = editaModal.querySelector('.modal-body #telefono')
      let inputCiudad = editaModal.querySelector('.modal-body #ciudad')
      let inputDireccion = editaModal.querySelector('.modal-body #direccion')

      let url = "./getCliente.php"
      let data = new FormData()
      data.append('cliente_id', id)

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          inputId.value = data.cliente_id
          inputNombre.value = data.nombre
          inputApellido.value = data.apellido
          inputEmail.value = data.email
          inputTelefono.value = data.telefono
          inputCiudad.value = data.ciudad
          inputDireccion.value = data.direccion
        })

    })

    eliminaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      eliminaModal.querySelector('.modal-footer #cliente_id').value = id
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>