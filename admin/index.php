<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
    header('location: ../index.php');
} else {
    if ($_SESSION['rol_id'] != 1) {
        header('location: ../index.php');
    }
}

require_once 'adminClass.php';
$admin = new Admin();

$atenciones_hoy = $admin->getAtencionesHoy();


?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'head.html'; ?>

<body>
    <?php include_once 'header.html'; ?>

    <main class="pt-5">
        <div class="container">
            <h1>Bienvenido al panel de administración</h1>
            <p>Desde aquí podrás gestionar las mascotas, clientes, personal, servicios de la veterinaria y más.</p>
            <article class="row">
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="card bg-primary-color text-white">
                        <div class="card-body">
                            <h5 class="card-title text-center text-dark">Mascotas</h5>
                            <p class="card-text text-center">Gestiona las mascotas registradas en la veterinaria.</p>
                            <a href="gestion_mascotas.php" class="btn btn-light d-block">Ir a mascotas</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="card bg-primary-color text-white">
                        <div class="card-body">
                            <h5 class="card-title text-center text-dark">Clientes</h5>
                            <p class="card-text text-center">Gestiona los clientes registrados en la veterinaria.</p>
                            <a href="gestion_clientes.php" class="btn btn-light d-block">Ir a clientes</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="card bg-primary-color text-white">
                        <div class="card-body">
                            <h5 class="card-title text-center text-dark">Personal</h5>
                            <p class="card-text text-center">Gestiona el personal registrado en la veterinaria.</p>
                            <a href="gestion_personal.php" class="btn btn-light d-block">Ir a personal</a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="card bg-primary-color text-white">
                        <div class="card-body">
                            <h5 class="card-title text-center text-dark">Servicios</h5>
                            <p class="card-text text-center">Gestiona los servicios ofrecidos en la veterinaria.</p>
                            <a href="gestion_servicios.php" class="btn btn-light d-block">Ir a servicios</a>
                        </div>
                    </div>
                </div>
            </article>
            <article class="row mt-5">

                <h2>Atenciones del día</h2>
                <hr>
                <?php if ($atenciones_hoy) { ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha y hora</th>
                                    <th scope="col">Mascota</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Servicio</th>
                                    <th scope="col">Personal a cargo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($atenciones_hoy as $atencion) { ?>

                                    <tr>
                                        <td><?= $atencion['fecha_hora']; ?></td>
                                        <td><?= $atencion['mascota_nombre']; ?></td>
                                        <td><?= $atencion['cliente_nombre'] . ' ' . $atencion['cliente_apellido']; ?></td>
                                        <td><?= $atencion['servicio_nombre']; ?></td>
                                        <td><?= $atencion['personal_nombre'] . ' ' . $atencion['personal_apellido']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else {
                ?>
                    <div class="fs-5">
                        <i>No hay atenciones pendientes para hoy</i>
                    </div>
                <?php } ?>
            </article>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>

</html>