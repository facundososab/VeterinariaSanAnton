<div class="modal fade" id="altaHospitalizacionModal" tabindex="-1" role="dialog" aria-labelledby="altaHospitalizacionModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="altaHospitalizacionModalLabel">
          <strong>Registrar hospitalización</strong>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formAltaHospitalizacion" action="./altaHospitalizacion.php" method="POST">
          <div class="mb-3">
            <label for="mascota_id" class="form-label">
              Mascota
            </label>
            <input type="text" class="form-control" id="buscar-mascota" onkeyup="filtrarMascotas()" placeholder="Ingrese nombre de la mascota..." onclick="event.stopPropagation()">
            <select class="form-select" id="mascota_id" name="mascota_id" required>
              <option value="" selected>
                Seleccionar mascota
              </option>
              <?php
              $mascotas = $admin->showAllMascotasConCliente();
              foreach ($mascotas as $mascota) {
                if ($mascota['fecha_muerte']) {
                  continue;
                }
              ?>
                <option value="<?= $mascota['mascota_id']; ?>">
                  <?= ucfirst($mascota['nombre']) .
                    ' - ' .
                    ucfirst($mascota['raza']) .
                    ' - ' .
                    ucfirst($mascota['color']) .
                    ' || ' .
                    ucfirst($mascota['cliente_nombre']) .
                    ' - ' .
                    $mascota['cliente_email']; ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha_hora_ingreso" class="form-label">
              Fecha y hora de ingreso
            </label>
            <input type="datetime-local" class="form-control" id="fecha_hora_ingreso" name="fecha_hora_ingreso" required />
            <div id="fecha_hora_ingresoError" class="form-text text-danger"></div>
          </div>
          <div class="mb-3">
            <label for="motivo" class="form-label">
              Motivo
            </label>
            <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
            <div id="motivoError" class="form-text text-danger"></div>
          </div>
          <div class="mb-3">
            <label for="personal_id" class="form-label">
              Personal responsable
            </label>
            <input type="text" class="form-control" id="buscar-personal" onkeyup="filtrarPersonales()" placeholder="Ingrese nombre del responsable..." onclick="event.stopPropagation()">
            <select class="form-select" id="personal_id" name="personal_id" required>
              <option value="" selected>
                Seleccionar personal
              </option>
              <?php
              $personal = $admin->showAllVeterinarios();
              foreach ($personal as $persona) { ?>
                <option value="<?= $persona['personal_id']; ?>">
                  <?= ucfirst($persona['nombre']) . ' ' . ucfirst($persona['apellido']); ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function filtrarMascotas() {
    let buscarMascota = document.getElementById('buscar-mascota');
    let filtro = buscarMascota.value.toLowerCase();
    let select = document.getElementById('mascota_id');
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

  function filtrarPersonales() {
    let buscarPersonal = document.getElementById('buscar-personal');
    let filtro = buscarPersonal.value.toLowerCase();
    let select = document.getElementById('personal_id');
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


  const formAltaHospitalizacion = document.getElementById('formAltaHospitalizacion')
  const validateAltaHospitalizacion = (e) => {
    e.preventDefault()
    const fecha_ingreso = document.getElementById('fecha_hora_ingreso')
    const motivo = document.getElementById('motivo')


    if (fecha_ingreso.value.trim() === '') {
      document.getElementById('fecha_hora_ingresoError').innerHTML = 'Campo obligatorio'
      return
    }

    if (fecha_ingreso.value.trim() > new Date().toISOString().slice(0, 16)) {
      document.getElementById('fecha_hora_ingresoError').innerHTML = 'La fecha y hora de ingreso no puede ser mayor a la actual'
      return
    }

    if (motivo.value.trim() === '') {
      document.getElementById('motivoError').innerHTML = 'Campo obligatorio'
      return
    }

    formAltaHospitalizacion.submit()

  }

  formAltaHospitalizacion.addEventListener('submit', validateAltaHospitalizacion)
</script>