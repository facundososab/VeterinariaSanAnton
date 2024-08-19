<div class="modal fade" id="altaAtencionModal" tabindex="-1" role="dialog" aria-labelledby="altaAtencionModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="altaAtencionModalLabel">
          Registrar atención
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAltaAtencion" action="./altaAtencion.php" method="POST">
          <div class="mb-3">
            <label for="fecha_hora" class="form-label">
              Fecha y hora
            </label>
            <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required />
          </div>
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
              $mascotas = $pelu->showAllMascotasConCliente();
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
            <label for="servicio_id" class="form-label">
              Servicio
            </label>
            <select class="form-select" id="servicio_id" name="servicio_id" required>
              <option value="" selected>
                Seleccionar servicio
              </option>
              <?php
              $servicios = $pelu->showAllServiciosPeluquero();
              foreach ($servicios as $servicio) { ?>
                <option value="<?= $servicio['servicio_id']; ?>">
                  <?= ucfirst($servicio['nombre']) . ' - ' . $servicio['tipo'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="titulo" class="form-label">
              Título
            </label>
            <input type="text" class="form-control" id="titulo" name="titulo" />
            <p id="tituloError" class="text-danger"></p>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">
              Descripción
            </label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            <p id="descripcionError" class="text-danger"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cerrar
            </button>
            <button type="submit" class="btn btn-primary">
              Registrar
            </button>
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


  const formAltaAtencion = document.getElementById('formAltaAtencion')
  const validateAltaAtencion = (e) => {
    e.preventDefault()
    const titulo = document.getElementById('titulo')
    const descripcion = document.getElementById('descripcion')

    if (titulo.value.trim() === '') {
      document.getElementById('tituloError').innerHTML = 'Campo obligatorio'
      return
    }

    if (descripcion.value.trim() === '') {
      document.getElementById('descripcionError').innerHTML = 'Campo obligatorio'
      return
    }

    formAltaAtencion.submit()

  }

  formAltaAtencion.addEventListener('submit', validateAltaAtencion)
</script>