<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$servicio_id = $_POST['servicio_id'];

try {
  if ($admin->bajaServicio($servicio_id)) {
    $_SESSION['mensaje'] = 'Servicio dado de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  if ($e->getCode() == 23000) {
    $_SESSION['mensaje'] = 'Error al dar de baja servicio: El servicio tiene registros asociados';
  } else {
    $_SESSION['mensaje'] = 'Error al dar de baja servicio: ' . $e->getMessage();
    $_SESSION['msg-color'] = 'danger';
  }
}

header('location: ./gestion_servicios.php');
