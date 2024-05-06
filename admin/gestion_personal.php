<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
  }
  if ($_SESSION['rol_id'] != 1) {
    header('Location: index.php');
  }

  require_once 'adminClass.php';
  $admin = new Admin();

  $personal = $admin->getAllPersonal();


?>

<!DOCTYPE html>
<html lang="en">
  <?php include_once 'head.html';?>
  <body>
    <?php include_once 'header.html';?>
    <main class="pt-5">
    <div class="container">    
        <div class="d-flex justify-content-lg-between">
          <h1 class="col-12 col-md-6">Personal</h1>          
          <!-- Button trigger modal -->
          <button
            type="button"
            class="btn btn-success col-12 col-md-2"
            data-bs-toggle="modal"
            data-bs-target="#altaPersonalModal"
          >
          <i class="bi bi-plus-circle-fill pe-1"></i> 
            Registrar personal
          </button>
        </div>
        <hr />  
        <!-- Verificar si hay personal registrado -->
        <?php if ($personal) { ?>
          <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Email</th>
              <th scope="col">Rol</th>
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
          <?php
          foreach ($personal as $row) {
            ?>
            <tr class="">
              <td><?= ucfirst($row['nombre']); ?></td>
              <td><?= ucfirst($row['apellido']); ?></td>
              <td><?= $row['email']; ?></td>
              <td><?= ucfirst($row['rol']); ?></td>
              <td class="d-flex column-gap-3">
                <button type="button" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#modificaPersonalModal" data-bs-id="<?=$row['personal_id']; ?>"><i class="bi bi-pencil-fill"></i></i> Editar</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bajaPersonalModal" data-bs-id="<?=$row['personal_id']; ?>"><i class="bi bi-trash"></i> Eliminar</button>
              </td>
            </tr>
          <?php } ?>
          </tbody>
          </table>
          <?php } else {
                  echo '<div class="alert alert-warning" role="alert">
                  No hay personal registrado';
            }?>

           
    </div>   
    </main>

    <!-- Modales -->
    <?php include './modales/altaPersonalModal.html';?>
    <?php include './modales/bajaPersonalModal.html';?>
    <?php include './modales/modificaPersonalModal.html';?>


    <script>
        let editaModal = document.getElementById('modificaPersonalModal')
        let eliminaModal = document.getElementById('bajaPersonalModal')

        editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #personal_id').value = ""
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #apellido').value = ""
            editaModal.querySelector('.modal-body #email').value = ""
            editaModal.querySelector('.modal-body #clave').value = ""
            editaModal.querySelector('.modal-body #rol').value = ""
        })

        editaModal.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            
            let inputId = editaModal.querySelector('.modal-body #personal_id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputApellido = editaModal.querySelector('.modal-body #apellido')
            let inputEmail = editaModal.querySelector('.modal-body #email')
            let inputClave = editaModal.querySelector('.modal-body #clave')
            let inputRol = editaModal.querySelector('.modal-body #rol')

            let url = "./getPersonal.php"
            let data = new FormData()
            data.append('personal_id', id)

            fetch(url, {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
              console.log(data)
                inputId.value = data.personal_id
                inputNombre.value = data.nombre
                inputApellido.value = data.apellido
                inputEmail.value = data.email
                inputClave.value = data.clave
                inputRol.value = data.rol
            })

        }) 

        eliminaModal.addEventListener('shown.bs.modal', event => {   
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            eliminaModal.querySelector('.modal-footer #id').value = id
        })

    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
