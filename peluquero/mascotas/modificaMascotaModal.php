<div class="modal fade" id="modificaMascotaModal" tabindex="-1" role="dialog" aria-labelledby="modificaMascotaLabel" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modificaMascotaLabel">
          <b>Modificación de Mascota</b>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./modificaMascota.php" method="post" id="formModificaMascota" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la mascota</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required />
          </div>
          <div class="mb-3">
            <label for="raza" class="form-label">Raza</label>
            <input type="text" class="form-control" id="raza" name="raza" required />
          </div>
          <div class="mb-3">
            <label for="edad" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required />
            <p id="fecha_nacError" class="text-danger"></p>
          </div>
          <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" class="form-control" id="color" name="color" required />
          </div>
          <div class="mb-3">
            <label for="img_mascota" class="form-label">Imagen de la mascota</label>
            <input type="file" class="form-control" id="img_mascota" name="img_mascota" />
          </div>
          <div class="mb-3">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#bajaMascotaPorMuerteModal" data-bs-id="<?= $mascota['mascota_id']; ?>">Dar de baja mascota por muerte</button>
          </div>
          <input type="hidden" name="mascota_id" id="mascota_id" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Validar fecha de nacimiento
  const formModificaMascota = document.getElementById('formModificaMascota');

  const validateModificaMascota = (e) => {
    e.preventDefault();
    const fecha_nac = document.getElementById('fecha_nac');

    if (fecha_nac.value > new Date().toISOString().split('T')[0]) {
      document.getElementById('fecha_nacError').innerHTML =
        'La fecha de nacimiento no puede ser mayor a la fecha actual';
      return;
    }

    formModificaMascota.submit();
  };

  formModificaMascota.addEventListener('submit', validateModificaMascota);
</script>