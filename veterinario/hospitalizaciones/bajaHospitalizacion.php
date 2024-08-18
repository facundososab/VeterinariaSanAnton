<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$hospitalizacion_id = $_POST['hospitalizacion_id_baja'];

if (empty($hospitalizacion_id)) {
  $_SESSION['mensaje'] = 'Debe seleccionar una hospitalización';
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

try {
  if ($vet->bajaHospitalizacion($hospitalizacion_id)) {
    $_SESSION['mensaje'] = 'Hospitalización dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja hospitalización: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: index.php');
