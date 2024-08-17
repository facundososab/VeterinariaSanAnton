<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

/***************** VALIDACIONES ***************/

$fecha_hora = $_POST['fecha_hora'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$mascota_id = $_POST['mascota_id'];
$servicio_id = $_POST['servicio_id'];
$personal_id = $_POST['personal_id'];

$errores = [];

if (empty($fecha_hora)) {
  $errores[] = 'Debe ingresar una fecha y hora';
}

if (empty($titulo)) {
  $errores[] = 'Debe ingresar un título';
}

if (empty($descripcion)) {
  $errores[] = 'Debe ingresar una descripción';
}

if (empty($mascota_id)) {
  $errores[] = 'Debe seleccionar una mascota';
}

if (empty($servicio_id)) {
  $errores[] = 'Debe seleccionar un servicio';
}

if (empty($personal_id)) {
  $errores[] = 'Debe seleccionar un personal';
}


if (!$vet->personalExiste($personal_id)) {
  $errores[] = 'El personal seleccionado no existe';
}

if (!$vet->servicioExiste($servicio_id)) {
  $errores[] = 'El servicio seleccionado no existe';
}

if (!$vet->mascotaExiste($mascota_id)) {
  $errores[] = 'La mascota seleccionada no existe';
}

if (!empty($errores)) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}
/*************************************************/

try {

  if ($vet->altaAtencion($fecha_hora, $titulo, $descripcion, $mascota_id, $servicio_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Atención registrada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al registrar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}


header('Location: index.php');
