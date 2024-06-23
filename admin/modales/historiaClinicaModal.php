<div class="modal fade" id="historiaClinicaModal" tabindex="-1" role="dialog" aria-labelledby="historiaClinicaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="historiaClinicaModalLabel">
          <b>Historia clínica</b>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="datos-mascotas">
          <h5>Datos de la mascota</h5>
          <div class="d-flex">
            <div class="col-6">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" readonly />
              </div>
              <div class="mb-3">
                <label for="raza" class="form-label">Raza</label>
                <input type="text" class="form-control" id="raza" readonly />
              </div>
              <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" readonly />
              </div>
              <div class="mb-3">
                <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
                <input type="text" class="form-control" id="fecha_nac" readonly />
              </div>
              <div class="atenciones-mascotas">
                <h5>Atenciones</h5>
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Fecha y hora</th>
                      <th scope="col">Titulo</th>
                      <th scope="col">Descripción</th>
                      <th scope="col">Servicio realizado</th>
                      <th scope="col">Personal a cargo</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>