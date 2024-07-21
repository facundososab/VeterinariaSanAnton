<div class="modal fade" id="modificaHospitalizacionModal" tabindex="-1" role="dialog" aria-labelledby="modificaHospitalizacionModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modificaHospitalizacionModalLabel">
          <strong>Modificar hospitalización</strong>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formModificaHospitalizacion" action="./modificaHospitalizacion.php" method="POST">
          <div class="mb-3">
            <label for="mascota_id_modifica" class="form-label">
              Mascota
            </label>
            <input type="text" class="form-control" id="buscar-mascota-modifica" onkeyup="filtrarMascotasModifica()" placeholder="Filtrar por nombre de la mascota..." onclick="event.stopPropagation()">
            <select class="form-select" id="mascota_id_modifica" name="mascota_id_modifica" required>
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
            <div class="mb-3">
              <label for="fecha_hora_ingreso_modifica" class="form-label">
                Fecha y hora de ingreso
              </label>
              <input type="datetime-local" class="form-control" id="fecha_hora_ingreso_modifica" name="fecha_hora_ingreso_modifica" required />
              <div id="fecha_hora_ingresoErrorModifica" class="form-text text-danger"></div>
            </div>
            <div class="mb-3">
              <label for="personal_id" class="form-label">
                Personal responsable
              </label>
              <input type="text" class="form-control" id="buscar-personal-modifica" onkeyup="filtrarPersonalesModifica()" placeholder="Filtrar personal por nombre..." onclick="event.stopPropagation()">
              <select class="form-select" id="personal_id_modifica" name="personal_id_modifica" required>
                <?php
                $personal = $admin->showAllVeterinarios();
                foreach ($personal as $persona) { ?>
                  <option value="<?= $persona['personal_id']; ?>">
                    <?= ucfirst($persona['nombre']) . ' ' . ucfirst($persona['apellido']); ?>
                  </option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="motivo_modifica" class="form-label">
                Motivo
              </label>
              <textarea class="form-control" id="motivo_modifica" name="motivo_modifica" rows="3" required></textarea>
              <div id="motivoErrorModifica" class="form-text text-danger"></div>
            </div>
            <input type="hidden" name="hospitalizacion_id" id="hospitalizacion_id" value="">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Modificar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const formModificaHospitalizacion = document.getElementById('formModificaHospitalizacion')
  const validateModificaHospitalizacion = (e) => {
    e.preventDefault()
    const fecha_ingreso = document.getElementById('fecha_hora_ingreso_modifica')
    const motivo = document.getElementById('motivo_modifica')


    if (fecha_ingreso.value.trim() === '') {
      document.getElementById('fecha_hora_ingresoErrorModifica').innerHTML = 'Campo obligatorio'
      return
    }

    if (fecha_ingreso.value.trim() > new Date().toISOString().slice(0, 16)) {
      document.getElementById('fecha_hora_ingresoErrorModifica').innerHTML = 'La fecha y hora de ingreso no puede ser mayor a la actual'
      return
    }

    if (motivo.value.trim() === '') {
      document.getElementById('motivoError').innerHTML = 'Campo obligatorio'
      return
    }

    formModificaHospitalizacion.submit()

  }

  formModificaHospitalizacion.addEventListener('submit', validateModificaHospitalizacion)
</script>