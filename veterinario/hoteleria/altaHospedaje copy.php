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

$mascota_id = $_POST['mascota_id'];
$fecha_hora_ingreso = $_POST['fecha_hora_ingreso'];
$fecha_hora_salida = $_POST['fecha_hora_salida'];
$personal_id = $_POST['personal_id'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($mascota_id)) {
  $errores[] = 'Debe seleccionar una mascota';
}

if (empty($fecha_hora_ingreso)) {
  $errores[] = 'Debe ingresar una fecha y hora de ingreso';
}

if (empty($fecha_hora_salida)) {
  $errores[] = 'Debe ingresar una fecha y hora de salida';
}

if (empty($personal_id)) {
  $errores[] = 'Debe seleccionar un personal responsable';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_hoteleria.php');
  exit;
}

try {

  if ($admin->altaHospedaje($fecha_hora_ingreso, $fecha_hora_salida, $mascota_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Hospedaje registrada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Ocurrió un error al registrar la hospedaje: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: ./gestion_hoteleria.php');
