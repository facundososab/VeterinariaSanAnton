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

$mascota_id = $_POST['mascota_id'];
$fecha_hora_ingreso = $_POST['fecha_hora_ingreso'];
$motivo = $_POST['motivo'];


/***** VALIDACIONES *****/

$errores = [];

if (empty($mascota_id)) {
  $errores[] = 'Debe seleccionar una mascota';
}

if (empty($fecha_hora_ingreso)) {
  $errores[] = 'Debe ingresar una fecha y hora de ingreso';
}

if (empty($motivo)) {
  $errores[] = 'Debe ingresar un motivo';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

try {

  if ($vet->altaHospitalizacion($fecha_hora_ingreso, $motivo, $mascota_id, $vet_id)) {

    $_SESSION['mensaje'] = 'Hospitalización registrada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Ocurrió un error al registrar la hospitalización: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: index.php');
