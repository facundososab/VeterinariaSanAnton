<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 4) {
  header('Location: ../../index.php');
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

$mascotas = null;

if ((isset($_GET['searchMascotas']) && !($_GET['searchMascotas'] == ''))) {
  $total_mascotas = $cliente->totalMascotasXBusqueda($cliente_id, $_GET['searchMascotas']);
  if ($total_mascotas == 0) {
    $_SESSION['mensaje'] = 'No se encontraron resultados';
    $_SESSION['msg-color'] = 'warning';
  } else {
    $mascotas = $cliente->getMascotasXBusqueda($cliente_id, $_GET['searchMascotas'], $empezar_desde, $tamano_paginas);
  }
} else {
  $total_mascotas = $cliente->totalMascotas($cliente_id);
  $mascotas = $cliente->getAllMascotas($cliente_id, $empezar_desde, $tamano_paginas);
  if (empty($mascotas)) {
    $_SESSION['mensaje'] = 'No tienes mascotas registradas';
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
        <h1 class="col-12 col-md-6">Mis mascotas</h1>
        <nav class="navbar col-12 col-md-6">
          <div class="container-fluid justify-content-end">
            <form class="d-flex flex-grow-1 flex-md-grow-0" role="search" id="formBuscadorMascotas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
              <input class="form-control me-2" type="search" placeholder="Nombre o raza" aria-label="Buscar" name="searchMascotas" value="<?php if (isset($_GET['searchMascotas'])) echo $_GET['searchMascotas']; ?>">
              <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
          </div>
        </nav>
      </div>
      <hr />
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
                        <div class="flex-grow-1 align-self-center text-center">
                          <strong><?= ucfirst($mascota['nombre']); ?></strong>
                        </div>
                        <img src=<?= $imagen ?> alt="<?= $mascota['nombre']; ?>" style="width: 80px; height: auto;">
                      </div>
                  </td>
                  <td><?= ucfirst($mascota['raza']); ?></td>
                  <td><?= ucfirst($mascota['color']); ?></td>
                  <td><?= $mascota['fecha_nac']; ?></td>
                  <td>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#historiaClinicaModal" data-bs-id="<?= $mascota['mascota_id']; ?>"><i class="bi bi-journal-medical"></i> Ver historia clínica</button>
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
  <?php include_once 'historiaClinicaModal.php'; ?>

  <script>
    let historiaClinicaModal = document.getElementById('historiaClinicaModal')

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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>