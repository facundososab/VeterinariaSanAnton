<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header('Location: index.php');
}elseif($_SESSION['rol_id'] != 1){
    header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$clientes = $admin->getAllClientes();

?>

<!DOCTYPE html>
<html lang="en">
  <?php include_once 'head.html';?>
  <body>
    <?php include_once 'header.html';?>
    <main class="pt-5">
    <div class="container">    
        <div class="d-flex justify-content-lg-between">
          <h1 class="col-12 col-md-6">Clientes</h1>
          <!-- Button trigger modal -->
          <button
            type="button"
            class="btn btn-success col-12 col-md-2"
            data-bs-toggle="modal"
            data-bs-target="#altaClienteModal"
          >
          <i class="bi bi-plus-circle-fill pe-1"></i> 
            Registrar cliente
          </button>
        </div>
        <hr />
        <!-- Verificar si hay clientes registrados -->
        <?php if ($clientes) { ?>
          <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Email</th>
              <th scope="col">Teléfono</th>
              <th scope="col">Ciudad</th>
              <th scope="col">Dirección</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($_SESSION['mensaje'])) { ?>
              <div class="alert alert-<?= $_SESSION['msg-color']; ?> alert-dismissible fade show" role="alert">
                  <?= $_SESSION['mensaje'];?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php
                unset($_SESSION['msg-color']);
                unset($_SESSION['mensaje']);
            } ?>
            <?php foreach ($clientes as $cliente) { ?>
              <tr>
                <td><?= ucfirst($cliente['nombre']); ?></td>
                <td><?= ucfirst($cliente['apellido']); ?></td>
                <td><?= $cliente['email']; ?></td>
                <td><?= $cliente['telefono']; ?></td>
                <td><?= ucfirst($cliente['ciudad']); ?></td>
                <td><?= ucfirst($cliente['direccion']); ?></td>
                <td class="d-flex column-gap-3">
                <button
                    href="#"
                    class="btn btn-warning flex-grow-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modificaClienteModal"
                    data-bs-id= "<?= $cliente['cliente_id']; ?>"
                  ><i class="bi bi-pencil-square"></i> Editar
                </button>
                <button
                    href="#"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#bajaClienteModal"
                    data-bs-id= "<?= $cliente['cliente_id']; ?>"
                  ><i class="bi bi-trash"></i> Eliminar
                </button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          </table>
          <?php } else {
                  echo '<div class="alert alert-warning" role="alert">
                  No hay clientes registrados';
            }?>
        </div>
    </main>

    <!-- Modales -->
    <?php include './modales/altaClienteModal.html';?>
    <?php include './modales/modificaClienteModal.html';?>
    <?php include './modales/bajaClienteModal.html';?>
    
    <script>
      let editaModal = document.getElementById('modificaClienteModal')
      let eliminaModal = document.getElementById('bajaClienteModal')

      editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #cliente_id').value = ""
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #apellido').value = ""
            editaModal.querySelector('.modal-body #email').value = ""
            editaModal.querySelector('.modal-body #telefono').value = ""
            editaModal.querySelector('.modal-body #ciudad').value = ""
            editaModal.querySelector('.modal-body #direccion').value = ""
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            
            let inputId = editaModal.querySelector('.modal-body #cliente_id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputApellido = editaModal.querySelector('.modal-body #apellido')
            let inputEmail = editaModal.querySelector('.modal-body #email')
            let inputTelefono = editaModal.querySelector('.modal-body #telefono')
            let inputCiudad = editaModal.querySelector('.modal-body #ciudad')
            let inputDireccion = editaModal.querySelector('.modal-body #direccion')

            let url = "./getCliente.php"
            let data = new FormData()
            data.append('cliente_id', id)

            fetch(url, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                inputId.value = data.cliente_id
                inputNombre.value = data.nombre
                inputApellido.value = data.apellido
                inputEmail.value = data.email
                inputTelefono.value = data.telefono
                inputCiudad.value = data.ciudad
                inputDireccion.value = data.direccion
            })

        }) 

        eliminaModal.addEventListener('shown.bs.modal', event => {   
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-footer #cliente_id').value = id
        })

    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>

  </body>
</html>

