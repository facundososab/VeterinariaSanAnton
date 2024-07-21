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

$hospitalizacion_id = $_POST['hospitalizacion_id_alta_medica'];
$observaciones = $_POST['observaciones_alta_medica'];


if (empty($hospitalizacion_id)) {
  $_SESSION['mensaje'] = 'Debe seleccionar una hospitalización';
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_hospitalizaciones.php');
  exit;
}

try {
  if ($admin->altaSalidaHospitalizacion($observaciones, $hospitalizacion_id)) {
    $_SESSION['mensaje'] = 'Alta médica registrada correctamente';
    $_SESSION['msg-color'] = 'success';
  } else {
    $_SESSION['mensaje'] = 'Error al registrar el alta médica';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar el alta médica';
  $_SESSION['msg-color'] = 'danger';
}

header('Location: ./gestion_hospitalizaciones.php');
