<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
}
if ($_SESSION['rol_id'] != 1) {
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

$personal = null;

if (isset($_GET['searchPersonal']) && !empty($_GET['searchPersonal'])) {
  $filtro = $_GET['searchPersonal'];
  $total_personal = $admin->totalPersonalXBusqueda($filtro);
  if ($total_personal == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $personal = $admin->getPersonalXBusqueda($filtro, $empezar_desde, $tamano_paginas);
  }
} else {
  $total_personal = $admin->totalPersonal();
  $personal = $admin->getAllPersonal($empezar_desde, $tamano_paginas);
  if (empty($personal)) {
    $_SESSION['mensaje'] = 'No hay personal registrado';
    $_SESSION['msg-color'] = 'warning';
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'head.html'; ?>

<body>
  <?php include_once 'header.html'; ?>
  <main class="pt-5">
    <div class="container">
      <div class="container">
        <div class="d-flex justify-content-lg-between px-2">
          <h1 class="col-5 col-md-6">Personal</h1>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaPersonalModal">
            <div class="d-flex align-items-center justify-content-center">
              <i class="bi bi-plus-circle-fill pe-1"></i>
              <span>Registrar personal</span>
            </div>
          </button>
        </div>
        <hr />
        <nav class="navbar">
          <div class="container-fluid justify-content-end">
            <form class="d-flex" role="search" id="formSearchPersonal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
              <input class="form-control me-2" type="search" placeholder="Nombre o raza" aria-label="Buscar" name="searchPersonal" value="<?= isset($_GET['searchPersonal']) ? $_GET['searchPersonal'] : ''; ?>">
              <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </nav>
        <!-- Verificar si hay personal registrado -->
        <?php if ($personal) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Email</th>
                  <th scope="col">Rol</th>
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
                <?php
                foreach ($personal as $row) {
                ?>
                  <tr class="">
                    <td><?= ucfirst($row['nombre']); ?></td>
                    <td><?= ucfirst($row['apellido']); ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= ucfirst($row['rol']); ?></td>
                    <td class="d-flex column-gap-3">
                      <button type="button" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#modificaPersonalModal" data-bs-id="<?= $row['personal_id']; ?>"><i class="bi bi-pencil-fill"></i></i> Editar</button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaPersonalModal" data-bs-id="<?= $row['personal_id']; ?>"><i class="bi bi-trash"></i> Eliminar</button>
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
    <nav aria-label="pagination-personal">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_personal / $tamano_paginas);

        if (isset($_GET['searchPersonal']) && !empty($_GET['searchPersonal'])) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active"><a class="page-link" href="gestion_personal.php?pagina=<?= $i ?>&searchPersonal=<?= $_GET['searchPersonal'] ?>"><?= $i ?></a></li>
            <?php } else { ?>
              <li class="page-item"><a class="page-link" href="gestion_personal.php?pagina=<?= $i ?>&searchPersonal=<?= $_GET['searchPersonal'] ?>"><?= $i ?></a></li>
        <?php }
          }
        } else {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) {
              echo "<li class='page-item active'><a class='page-link' href='gestion_personal.php?pagina=$i'>$i</a></li>";
            } else {
              echo "<li class='page-item'><a class='page-link' href='gestion_personal.php?pagina=$i'>$i</a></li>";
            }
          }
        }
        ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include './modales/altaPersonalModal.html'; ?>
  <?php include './modales/bajaPersonalModal.html'; ?>
  <?php include './modales/modificaPersonalModal.html'; ?>


  <script>
    let editaModal = document.getElementById('modificaPersonalModal')
    let eliminaModal = document.getElementById('bajaPersonalModal')

    editaModal.addEventListener('hide.bs.modal', event => {
      editaModal.querySelector('.modal-body #personal_id').value = ""
      editaModal.querySelector('.modal-body #nombre').value = ""
      editaModal.querySelector('.modal-body #apellido').value = ""
      editaModal.querySelector('.modal-body #emailModificaPersonal').value = ""
      editaModal.querySelector('.modal-body #claveModificaPersonal').value = ""
      editaModal.querySelector('.modal-body #rol').value = ""
    })

    editaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')

      let inputId = editaModal.querySelector('.modal-body #personal_id')
      let inputNombre = editaModal.querySelector('.modal-body #nombre')
      let inputApellido = editaModal.querySelector('.modal-body #apellido')
      let inputEmail = editaModal.querySelector('.modal-body #emailModificaPersonal')
      let inputClave = editaModal.querySelector('.modal-body #claveModificaPersonal')

      let url = "./getPersonal.php"
      let data = new FormData()
      data.append('personal_id', id)

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          console.log(data)
          inputId.value = data.personal_id
          inputNombre.value = data.nombre
          inputApellido.value = data.apellido
          inputEmail.value = data.email
          inputClave.value = data.clave
        })

    })

    eliminaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      eliminaModal.querySelector('.modal-footer #id').value = id
    })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>