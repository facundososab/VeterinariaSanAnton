<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$hospedaje_id = $_POST['hospedaje_id_baja'];

if (empty($hospedaje_id)) {
  $_SESSION['mensaje'] = 'Debe seleccionar una hospedaje';
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_hoteleria.php');
  exit;
}

try {
  if ($admin->bajaHospedaje($hospedaje_id)) {
    $_SESSION['mensaje'] = 'Hospedaje dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja hospedaje: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_hoteleria.php');
