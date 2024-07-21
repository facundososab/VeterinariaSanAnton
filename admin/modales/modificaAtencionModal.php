<div class="modal fade" id="modificaAtencionModal" tabindex="-1" role="dialog" aria-labelledby="modificaAtencionModalLabel" aria-modal="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modificaAtencionModalLabel">
          Registrar atención
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formModificaAtencion" action="./modificaAtencion.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="fecha_hora_modifica" class="form-label"> Fecha y hora </label>
            <input type="datetime-local" class="form-control" id="fecha_hora_modifica" name="fecha_hora_modifica" required />
          </div>
          <div class="mb-3">
            <label for="mascota_id_modifica" class="form-label"> Mascota </label>
            <input type="text" class="form-control" id="buscar-mascota-modifica" onkeyup="filtrarMascotasModifica()" placeholder="Ingrese nombre de la mascota..." onclick="event.stopPropagation()" />
            <select class="form-select" id="mascota_id_modifica" name="mascota_id_modifica" required>
              <option value="" selected>Seleccionar mascota</option>
              <?php
              $mascotas = $admin->showAllMascotasConCliente();
              foreach ($mascotas as $mascota) {
                if ($mascota['fecha_muerte']) {
                  continue;
                } ?>
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
            <label for="servicio_id_modifica" class="form-label"> Servicio </label>
            <select class="form-select" id="servicio_id_modifica" name="servicio_id_modifica" onchange="selectItemModifica(this.value)" required>
              <option value="" selected>Seleccionar servicio</option>
              <?php
              $servicios = $admin->showAllServicios();
              foreach ($servicios as
                $servicio) { ?>
                <option value="<?= $servicio['servicio_id']; ?>">
                  <?= ucfirst($servicio['nombre']) . ' - ' . $servicio['tipo'] ?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="personal_id_modifica" class="form-label"> Personal </label>
            <input type="text" class="form-control" id="buscar-personal-modifica" onkeyup="filtrarPersonalesModifica()" placeholder="Ingrese nombre del personal..." onclick="event.stopPropagation()" />
            <select class="form-select" id="personal_id_modifica" name="personal_id_modifica" required>
              <option selected>Seleccionar personal</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="titulo_modifica" class="form-label"> Título </label>
            <input type="text" class="form-control" id="titulo_modifica" name="titulo_modifica" required />
            <div id="tituloErrorModifica" class="form-text text-danger"></div>
          </div>
          <div class="mb-3">
            <label for="descripcion_modifica" class="form-label"> Descripción </label>
            <textarea class="form-control" id="descripcion_modifica" name="descripcion_modifica" required></textarea>
            <div id="descripcionErrorModifica" class="form-text text-danger"></div>
          </div>
          <input type="hidden" id="atencion_id" name="atencion_id" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cerrar
          </button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
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

  function filtrarPersonalesModifica() {
    let buscarPersonal = document.getElementById('buscar-personal-modifica');
    let filtro = buscarPersonal.value.toLowerCase();
    let select = document.getElementById('personal_id_modifica');
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

  function selectItemModifica(item) {
    let servicio_id = item
    let personal_id = document.getElementById('personal_id_modifica');

    let url = './getPersonalByServicio.php'
    let data = new FormData()
    data.append('servicio_id', servicio_id)
    fetch(url, {
        method: 'POST',
        body: data
      })
      .then(response => response.json())
      .then(data => {
        personal_id.innerHTML = ''
        data.forEach(personal => {
          personal_id.innerHTML += `<option value="${personal.personal_id}">${personal.nombre} ${personal.apellido} - ${personal.email}</option>`
        })

      })
  }

  const formModificaAtencion = document.getElementById('formModificaAtencion')
  const validateModificaAtencion = (e) => {
    e.preventDefault()
    const titulo = document.getElementById('titulo_modifica')
    const descripcion = document.getElementById('descripcion_modifica')

    if (titulo.value.trim() === '') {
      document.getElementById('tituloErrorModifica').innerHTML = 'Campo obligatorio'
      return
    }

    if (descripcion.value.trim() === '') {
      document.getElementById('descripcionErrorModifica').innerHTML = 'Campo obligatorio'
      return
    }

    formModificaAtencion.submit()

  }

  formModificaAtencion.addEventListener('submit', validateModificaAtencion)
</script>