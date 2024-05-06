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

$total_mascotas = $admin->totalMascotas();

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$mascotas = $admin->getAllMascotas($empezar_desde);

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'head.html'; ?>

<body>
  <?php include_once 'header.html'; ?>
  <main class="pt-5">
    <div class="container">
      <div class="d-flex justify-content-lg-between">
        <h1 class="col-12 col-md-6">Mascotas</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-12 col-md-2" data-bs-toggle="modal" data-bs-target="#altaMascotaModal">
          <i class="bi bi-plus-circle-fill pe-1"></i>
          Registrar mascota
        </button>
      </div>
      <hr />
      <!-- Verificar si hay mascotas registradas -->
      <?php if ($mascotas) { ?>
        <table class="table table-striped table-hover align-middle">
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
                <?= $_SESSION['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php
              unset($_SESSION['msg-color']);
              unset($_SESSION['mensaje']);
            } ?>
            <?php foreach ($mascotas as $mascota) {
            ?>
              <tr>
                <td class="d-flex align-items-stretch p-2">
                  <div>
                    <img src="<?= "../img_mascotas" . $mascota['mascota_id'] . '.jpg'; ?>" alt="">
                  </div>
                  <div class="flex-grow-1">
                    <?= ucfirst($mascota['nombre']); ?>
                  </div>
                </td>
                <td><?= ucfirst($mascota['raza']); ?></td>
                <td><?= ucfirst($mascota['color']); ?></td>
                <td><?= $mascota['fecha_nac']; ?></td>
                <td><span><?= ucfirst($mascota['cliente_nombre']) . ' ' . ucfirst($mascota['cliente_apellido']) ?> </span><br><span><?= '(' . $mascota['cliente_email'] . ')' ?></td>
                <td class="d-flex column-gap-3 py-3">
                  <button type="button" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#modificaMascotaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-pencil-fill"></i></i> Editar</button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaMascotaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-trash-fill"></i> Eliminar</button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      <?php

      } else { ?>
        <div class="alert alert-warning" role="alert">
          No hay mascotas registradas
        </div>
      <?php } ?>
    </div>
  </main>
  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="Page navigation example">
      <ul class="pagination
          justify-content-center">
        <?php
        $total_paginas = ceil($total_mascotas / $tamano_paginas);
        ?>

        <?php for ($i = 1; $i <= $total_paginas; $i++) {
          if ($i == $pagina) {
            echo "<li class='page-item active'><a class='page-link' href='gestion_mascotas.php?pagina=$i'>$i</a></li>";
          } else {
            echo "<li class='page-item'><a class='page-link' href='gestion_mascotas.php?pagina=$i'>$i</a></li>";
          }
        } ?>

      </ul>
    </nav>
  </footer>

  <!-- Modales -->
  <?php include_once './modales/altaMascotaModal.php'; ?>
  <?php include_once './modales/modificaMascotaModal.html'; ?>
  <?php include_once './modales/bajaMascotaModal.html'; ?>

  <script>
    let editaModal = document.getElementById('modificaMascotaModal')
    let eliminaModal = document.getElementById('bajaMascotaModal')

    editaModal.addEventListener('hide.bs.modal', event => {
      editaModal.querySelector('.modal-body #mascota_id').value = ''
      editaModal.querySelector('.modal-body #nombre').value = ''
      editaModal.querySelector('.modal-body #raza').value = ''
      editaModal.querySelector('.modal-body #img_mascota').value = ''
      editaModal.querySelector('.modal-body #color').value = ''
      editaModal.querySelector('.modal-body #fecha_nac').value = ''
    })

    editaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let mascota_id = button.getAttribute('data-bs-id')

      let inputId = editaModal.querySelector('.modal-body #mascota_id')
      let inputNombre = editaModal.querySelector('.modal-body #nombre')
      let inputRaza = editaModal.querySelector('.modal-body #raza')
      let inputFoto = editaModal.querySelector('.modal-body #img_mascota')
      let inputColor = editaModal.querySelector('.modal-body #color')
      let inputFechaNac = editaModal.querySelector('.modal-body #fecha_nac')

      console.log(mascota_id)
      let url = './getMascota.php'
      let data = new FormData()
      data.append('mascota_id', mascota_id)

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          inputId.value = data.mascota_id
          inputNombre.value = data.nombre
          inputRaza.value = data.raza
          inputFoto.src = '../img_mascotas' + data.mascota_id + '.jpg' ?? undefined
          inputColor.value = data.color
          inputFechaNac.value = data.fecha_nac

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