<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$veterinario_id = $_SESSION['id'];

$tamano_paginas = 8;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$mascotas = null;

if ((isset($_GET['searchMascotas']) && !($_GET['searchMascotas'] == ''))) {
  $total_mascotas = $vet->totalMascotasXBusqueda($_GET['searchMascotas']);
  if ($total_mascotas == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $mascotas = $vet->getMascotasXBusqueda($_GET['searchMascotas'], $empezar_desde, $tamano_paginas);
  }
} else {
  $total_mascotas = $vet->totalMascotas();
  $mascotas = $vet->getAllMascotas($empezar_desde, $tamano_paginas);
  if (empty($mascotas)) {
    $_SESSION['mensaje'] = 'No hay mascotas registradas';
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
        <h1 class="col-5 col-md-6">Mascotas</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success col-5 col-md-2 ms-auto" data-bs-toggle="modal" data-bs-target="#altaMascotaModal">
          <div class="d-flex align-items-center justify-content-center">
            <i class="bi bi-plus-circle-fill pe-1"></i>
            <span>Registrar mascota</span>
          </div>
        </button>
      </div>
      <hr />
      <nav class="navbar">
        <div class="container-fluid justify-content-end">
          <form class="d-flex" role="search" id="formBuscadorMascotas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <input class="form-control me-2" type="search" placeholder="Nombre o raza" aria-label="Buscar" name="searchMascotas">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
          </form>
        </div>
      </nav>
      <!-- Verificar si hay mascotas registradas -->
      <?php if ($mascotas) { ?>
        <div class="table-responsive mb-5">
          <table class="table table-striped table-hover align-middle mb-5">
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
                $imagen = '../../img_mascotas/' . $mascota['mascota_id'] . '.jpg';
                if (!file_exists($imagen)) {
                  $imagen = '../../img_mascotas/default.jpg';
                }
              ?>
                <tr>
                  <td>
                    <div class="d-flex">
                      <div>
                        <img src=<?= $imagen ?> alt="<?= $mascota['nombre']; ?>" style="width: 80px; height: auto;">
                        <div class="flex-grow-1 align-self-center">
                          <?= ucfirst($mascota['nombre']); ?>
                        </div>
                      </div>
                  </td>
                  <td><?= ucfirst($mascota['raza']); ?></td>
                  <td><?= ucfirst($mascota['color']); ?></td>
                  <td><?= $mascota['fecha_nac']; ?></td>
                  <td><span><?= ucfirst($mascota['cliente_nombre']) . ' ' . ucfirst($mascota['cliente_apellido']) ?> </span><br><span><?= '(' . $mascota['cliente_email'] . ')' ?></td>
                  <td class="py-3">
                    <div class="d-flex column-gap-3">
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificaMascotaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-pencil-fill"></i></i> Editar</button>
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaMascotaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-trash-fill"></i> Eliminar</button>
                      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#historiaClinicaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-journal-medical"></i> Ver historia clínica</button>
                    </div>
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
          unset($_SESSION['mensaje']); ?>
        </div>
      <?php

      } ?>
    </div>
  </main>


  <footer class="footer mt-auto py-3 bg-light fixed-bottom">
    <nav aria-label="navigation-mascotas">
      <ul class="pagination justify-content-center">
        <?php
        $total_paginas = ceil($total_mascotas / $tamano_paginas);

        if (isset($_GET['searchMascotas']) && !($_GET['searchMascotas'] == '')) {
          for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina) { ?>
              <li class="page-item active"><a class="page-link" href="?pagina=<?= $i ?>&searchMascotas=<?= $_GET['searchMascotas'] ?>"><?= $i ?></a></li>
            <?php } else { ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?= $i ?>&searchMascotas=<?= $_GET['searchMascotas'] ?>"><?= $i ?></a></li>
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
  <?php include_once 'altaMascotaModal.php'; ?>
  <?php include_once 'modificaMascotaModal.php'; ?>
  <?php include_once 'bajaMascotaModal.html'; ?>
  <?php include_once 'bajaMascotaPorMuerteModal.html'; ?>
  <?php include_once 'historiaClinicaModal.php'; ?>

  <script>
    let editaModal = document.getElementById('modificaMascotaModal')
    let eliminaModal = document.getElementById('bajaMascotaModal')
    let historiaClinicaModal = document.getElementById('historiaClinicaModal')
    let bajaMascotaPorMuerteModal = document.getElementById('bajaMascotaPorMuerteModal')

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
          inputFoto.src = '../img_mascotas/' + data.mascota_id + '.jpg' ?? undefined
          inputColor.value = data.color
          inputFechaNac.value = data.fecha_nac

        })

    })

    eliminaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      eliminaModal.querySelector('.modal-footer #id').value = id
    })

    historiaClinicaModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let mascota_id = button.getAttribute('data-bs-id')

      let nombre = historiaClinicaModal.querySelector('.modal-body #nombre')
      let raza = historiaClinicaModal.querySelector('.modal-body #raza')
      let color = historiaClinicaModal.querySelector('.modal-body #color')
      let fecha_nac = historiaClinicaModal.querySelector('.modal-body #fecha_nac')
      let cliente = historiaClinicaModal.querySelector('.modal-body #cliente')

      let url = './getMascota.php'
      let data = new FormData()
      data.append('mascota_id', mascota_id)

      fetch(url, {
          method: 'POST',
          body: data
        })
        .then(response => response.json())
        .then(data => {
          nombre.textContent = data.nombre
          raza.textContent = data.raza
          color.textContent = data.color
          fecha_nac.textContent = data.fecha_nac
          cliente.textContent = data.cliente_nombre + ' ' + data.cliente_apellido + ' (' + data.cliente_email + ')'
        })

      let atenciones = historiaClinicaModal.querySelector('.modal-body .atenciones-mascotas tbody')

      let urlAtenciones = './getHistoriaClinicaMascota.php'
      let dataAtenciones = new FormData()
      dataAtenciones.append('mascota_id', mascota_id)

      fetch(urlAtenciones, {
          method: 'POST',
          body: dataAtenciones
        })
        .then(response => response.json())
        .then(data => {
          atenciones.innerHTML = ''
          //agregar atenciones a la tabla
          data.forEach(atencion => {
            let tr = document.createElement('tr')
            tr.innerHTML = `
              <td>${atencion.fecha_hora}</td>
              <td>${atencion.titulo}</td>
              <td>${atencion.descripcion}</td>
              <td>${atencion.servicio_nombre}</td>
              <td>${atencion.personal_nombre} ${atencion.personal_apellido}</td>
            `
            atenciones.appendChild(tr)
          })
        })
    })

    bajaMascotaPorMuerteModal.addEventListener('shown.bs.modal', event => {
      let button = event.relatedTarget
      let mascota_id = button.getAttribute('data-bs-id')

      let inputId = bajaMascotaPorMuerteModal.querySelector('.modal-footer #id_mascota')
      inputId.value = mascota_id
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>