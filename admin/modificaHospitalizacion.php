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

$hospitalizacion_id = $_POST['hospitalizacion_id_modifica'];
$fecha_hora_ingreso = $_POST['fecha_hora_ingreso_modifica'];
$motivo = $_POST['motivo_modifica'];
$mascota_id = $_POST['mascota_id_modifica'];
$personal_id = $_POST['personal_id_modifica'];

/***** VALIDACIONES *****/

$errores = [];
echo $hospitalizacion_id, $fecha_hora_ingreso, $motivo, $mascota_id, $personal_id;
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

if (empty($personal_id)) {
  $errores[] = 'Debe seleccionar un personal';
}


if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_hospitalizaciones.php');
  exit;
}

try {

  if ($admin->modificaHospitalizacion($hospitalizacion_id, $fecha_hora_ingreso, $motivo, $mascota_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Hospitalización modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Ocurrió un error al modificar la hospitalización: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_hospitalizaciones.php');
