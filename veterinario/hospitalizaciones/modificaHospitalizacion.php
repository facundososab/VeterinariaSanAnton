<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
  header('location: ../../index.php');
} else {
  if ($_SESSION['rol_id'] != 2) {
    header('location: ../../index.php');
  }
}

require_once '../vetClass.php';
$vet = new Veterinario();
$vet_id = $_SESSION['id'];

$hospitalizacion_id = $_POST['hospitalizacion_id'];
$fecha_hora_ingreso = $_POST['fecha_hora_ingreso_modifica'];
$motivo = $_POST['motivo_modifica'];
$mascota_id = $_POST['mascota_id_modifica'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($hospitalizacion_id)) {
  $errores[] = 'Debe seleccionar una hospitalización';
}

if (empty($fecha_hora_ingreso)) {
  $errores[] = 'Debe ingresar una fecha y hora de ingreso';
}

if (empty($motivo)) {
  $errores[] = 'Debe ingresar un motivo';
}

if (empty($mascota_id)) {
  $errores[] = 'Debe seleccionar una mascota';
}


if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

try {

  if ($vet->modificaHospitalizacion($hospitalizacion_id, $fecha_hora_ingreso, $motivo, $mascota_id, $vet_id)) {

    $_SESSION['mensaje'] = 'Hospitalización modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Ocurrió un error al modificar la hospitalización: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: index.php');
