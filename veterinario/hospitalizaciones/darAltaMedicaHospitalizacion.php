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

$hospitalizacion_id = $_POST['hospitalizacion_id_alta_medica'];
$observaciones = $_POST['observaciones_alta_medica'];


if (empty($hospitalizacion_id)) {
  $_SESSION['mensaje'] = 'Debe seleccionar una hospitalización';
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

try {
  if ($vet->altaSalidaHospitalizacion($observaciones, $hospitalizacion_id)) {
    $_SESSION['mensaje'] = 'Alta médica registrada correctamente';
    $_SESSION['msg-color'] = 'success';
  } else {
    $_SESSION['mensaje'] = 'Error al registrar el alta médica';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar el alta médica';
  $_SESSION['msg-color'] = 'danger';
}

header('Location: index.php');
