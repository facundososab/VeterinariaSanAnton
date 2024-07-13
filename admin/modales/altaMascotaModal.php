<div class="modal fade" id="altaMascotaModal" tabindex="-1" role="dialog" aria-labelledby="altaMascotaModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="altaMascotaModalLabel">
          Registrar mascota
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="./altaMascota.php" method="POST" id="formAltaMascota" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required />
          </div>
          <div class="mb-3">
            <label for="raza" class="form-label">Raza</label>
            <input type="text" class="form-control" id="raza" name="raza" required />
          </div>
          <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input value="Sin definir" type="text" class="form-control" id="color" name="color" required />
          </div>
          <div class="mb-3">
            <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required />
            <p id="fecha_nacError" class="text-danger"></p>
          </div>
          <div class="mb-3">
            <label for="img_mascota" class="form-label">Imagen de la mascota</label>
            <input type="file" class="form-control" id="img_mascota" name="img_mascota" />
          </div>
          <div class="mb-3 dropdown">
            <label for="cliente_id" class="form-label">Dueño</label>
            <input type="text" class="form-control" id="buscar-dueño" onkeyup="filtrarDueños()" placeholder="Ingrese nombre del dueño..." onclick="event.stopPropagation()">
            <select class="form-select" id="cliente_id" name="cliente_id" required>
              <option value="" selected>Seleccionar cliente</option>
              <?php
              $clientes = $admin->showAllClientes();
              foreach ($clientes as $cliente) { ?>
                <option value="<?= $cliente['cliente_id']; ?>">
                  <?= ucfirst($cliente['nombre']) . ' ' . ucfirst($cliente['apellido']) . ' - ' . $cliente['email']; ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function filtrarDueños() {
    let buscarDueño = document.getElementById('buscar-dueño');
    let filtro = buscarDueño.value.toLowerCase();
    let select = document.getElementById('cliente_id');
    let option = select.getElementsByTagName('option');

    for (let i = 0; i < option.length; i++) {
      let txtValue = option[i].textContent || option[i].innerText;
      if (txtValue.toLowerCase().indexOf(filtro) > -1) {
        option[i].style.display = '';
      } else {
        option[i].style.display = 'none';
      }
    }


  }

  // Validar fecha de nacimiento
  const formAltaMascota = document.getElementById('formAltaMascota');

  const validateAltaMascota = (e) => {
    e.preventDefault();
    const fecha_nac = document.getElementById('fecha_nac');


    if (fecha_nac.value > new Date().toISOString().split('T')[0]) {
      document.getElementById('fecha_nacError').innerHTML = 'La fecha de nacimiento no puede ser mayor a la fecha actual';
      return;
    }

    formAltaMascota.submit();

  }

  formAltaMascota.addEventListener('submit', validateAltaMascota);
</script>