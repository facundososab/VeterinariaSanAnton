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

$hospedaje_id = $_POST['hospedaje_id'];
$fecha_hora_ingreso = $_POST['fecha_hora_ingreso_modifica'];
$fecha_hora_salida = $_POST['fecha_hora_salida_modifica'];
$mascota_id = $_POST['mascota_id_modifica'];
$vet_id = $_SESSION['id'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($hospedaje_id)) {
  $errores[] = 'Debe seleccionar una hospedaje';
}

if (empty($fecha_hora_ingreso)) {
  $errores[] = 'Debe ingresar una fecha y hora de ingreso';
}

if (empty($fecha_hora_salida)) {
  $errores[] = 'Debe ingresar una fecha y hora de salida';
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

  if ($vet->modificaHospedaje($hospedaje_id, $fecha_hora_ingreso, $fecha_hora_salida, $mascota_id, $vet_id)) {
    $_SESSION['mensaje'] = 'Hospedaje modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Ocurrió un error al modificar la hospedaje: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: index.php');
