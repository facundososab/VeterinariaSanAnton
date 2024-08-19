<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';
$pelu = new Peluquero();

$mascota_id = $_POST['id_mascota'];
$fecha_muerte = $_POST['fecha_muerte'];

try {
  if ($pelu->muerteMascota($mascota_id, $fecha_muerte)) {
    $_SESSION['mensaje'] = 'Muerte de mascota registrada correctamente';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar la muerte de la mascota: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: index.php');
