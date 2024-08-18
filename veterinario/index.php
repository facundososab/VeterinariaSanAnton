<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['rol_id'])) {
    header('location: ../index.php');
} else {
    if ($_SESSION['rol_id'] != 2) {
        header('location: ../index.php');
    }
}

require('vetClass.php');
$vet = new Veterinario();

$veterinario_id = $_SESSION['id'];

$atenciones_hoy = $vet->getAtencionesHoy($veterinario_id);

$proximas_atenciones = $vet->getProximasAtenciones($veterinario_id);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Veterinaria San Anton</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Kiwi+Maru:wght@300;400;500&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" href="../img/logo.svg" />
</head>

<body>
    <nav
        class="navbar sticky-top navbar-expand-lg navbar-bg-color d-lg-flex justify-content-lg-between rounded-4 rounded-top-0 nav-shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="../img/logo.svg" alt="Veterinaria San Antón" /></a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="collapse navbar-collapse row mx-auto align-items-center justify-content-lg-between"
                id="navbarNavDropdown">
                <ul
                    class="navbar-nav d-flex ms-auto mb-2 mb-lg-0 align-items-center justify-content-lg-between col-lg-9">
                    <li class="nav-item">
                        <a class="nav-link" href="./atenciones/index.php">Atenciones</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./hospitalizaciones/index.php">Hospitalizaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./hoteleria/index.php">Hoteleria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./mascotas/index.php">Mascotas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./clientes/index.php">Clientes</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-label="Opciones de perfil">
                            <i class="bi bi-person-circle fs-3"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="./perfil.php" aria-label="Perfil">Ver perfil</a>
                            </li>
                            <hr />
                            <li>
                                <a
                                    class="dropdown-item text-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#cierreSesionModal">Cerrar sesion</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div
        class="modal fade"
        id="cierreSesionModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Cierre de sesión
                    </h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">¿Estas seguro que deseas cerrar sesión?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn bg-danger">
                        <a
                            href="../pagina-login/cerrar_sesion.php"
                            class="text-white link-underline link-underline-opacity-0">Cerrar sesión</a>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <main class="pt-5">
        <div class="container">
            <h1>Bienvenido, <?php echo ucfirst($_SESSION['nombre']); ?></h1>
            <hr>
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
            <hr>
            <article class="row mt-5">
                <h2>Próximas atenciones</h2>
                <hr>
                <?php if ($proximas_atenciones) { ?>
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
                                foreach ($proximas_atenciones as $atencion) { ?>

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
                        <i>No hay proximas atenciones pendientes</i>
                    </div>
                <?php } ?>


        </div>
    </main>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>