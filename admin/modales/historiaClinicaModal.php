<div class="modal fade" id="historiaClinicaModal" tabindex="-1" role="dialog" aria-labelledby="historiaClinicaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="historiaClinicaModalLabel">
          <b>HISTORIA CLÍNICA</b>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="datos-mascotas">
          <h5>Datos de la mascota</h5>
          <hr>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <th scope="row">Nombre</th>
                  <td id="nombre"></td>

                </tr>
                <tr>
                  <th scope="row">Raza</th>
                  <td id="raza"></td>
                </tr>
                <tr>
                  <th scope="row">Color</th>
                  <td id="color"></td>
                </tr>
                <tr>
                  <th scope="row">Fecha de nacimiento</th>
                  <td id="fecha_nac"></td>
                </tr>
                <tr>
                  <th scope="row">Dueño</th>
                  <td id="cliente"></td>
                </tr>

              </tbody>
            </table>
          </div>
          <br>
          <div class="atenciones-mascotas">
            <h5>Atenciones realizadas</h5>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">Fecha y hora</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Servicio realizado</th>
                    <th scope="col">Personal a cargo</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>