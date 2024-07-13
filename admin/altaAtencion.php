<?php

session_start();

require_once 'adminClass.php';
$admin = new Admin();

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


if (!$admin->personalExiste($personal_id)) {
  $errores[] = 'El personal seleccionado no existe';
}

if (!$admin->servicioExiste($servicio_id)) {
  $errores[] = 'El servicio seleccionado no existe';
}

if (!$admin->mascotaExiste($mascota_id)) {
  $errores[] = 'La mascota seleccionada no existe';
}

if (!empty($errores)) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_atenciones.php');
  exit;
}
/*************************************************/

try {

  if ($admin->altaAtencion($fecha_hora, $titulo, $descripcion, $mascota_id, $servicio_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Atención registrada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al registrar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}


header('Location: gestion_atenciones.php');
