<div class="modal fade" id="modificaHospedajeModal" tabindex="-1" role="dialog" aria-labelledby="modificaHospedajeModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modificaHospedajeModalLabel">
          <strong>Modificar hospedaje</strong>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="formModificaHospedaje" action="./modificaHospedaje.php" method="POST">
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
              $mascotas = $vet->showAllMascotasConCliente();
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
            <label for="fecha_hora_ingreso_modifica" class="form-label">
              Fecha y hora de ingreso
            </label>
            <input type="date" class="form-control" id="fecha_hora_ingreso_modifica" name="fecha_hora_ingreso_modifica" required />
            <div id="fecha_hora_ingresoErrorModifica" class="form-text text-danger"></div>
          </div>
          <div class="mb-3">
            <label for="fecha_hora_salida_modifica" class="form-label">
              Fecha y hora de salida
            </label>
            <input type="date" class="form-control" id="fecha_hora_salida_modifica" name="fecha_hora_salida_modifica" required />
            <div id="fecha_hora_salidaErrorModifica" class="form-text text-danger"></div>
          </div>
          <input type="hidden" name="hospedaje_id" id="hospedaje_id" value="">
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
  function filtrarMascotasModifica() {
    let buscarMascota = document.getElementById('buscar-mascota-modifica');
    let filtro = buscarMascota.value.toLowerCase();
    let select = document.getElementById('mascota_id_modifica');
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

  const formModificaHospedaje = document.getElementById('formModificaHospedaje')
  const validateModificaHospedaje = (e) => {
    e.preventDefault()
    const fecha_ingreso = document.getElementById('fecha_hora_ingreso_modifica')
    const fecha_salida = document.getElementById('fecha_hora_salida_modifica')
    const motivo = document.getElementById('motivo_modifica')


    if (fecha_ingreso.value.trim() === '') {
      document.getElementById('fecha_hora_ingresoErrorModifica').innerHTML = 'Campo obligatorio'
      return
    }

    if (fecha_salida.value.trim() === '') {
      document.getElementById('fecha_hora_salidaErrorModifica').innerHTML = 'Campo obligatorio'
      return
    }

    if (fecha_salida.value.trim() < fecha_ingreso.value.trim()) {
      document.getElementById('fecha_hora_salidaErrorModifica').innerHTML = 'La fecha y hora de salida no puede ser menor a la de ingreso'
      return
    }

    formModificaHospedaje.submit()

  }

  formModificaHospedaje.addEventListener('submit', validateModificaHospedaje)
</script>