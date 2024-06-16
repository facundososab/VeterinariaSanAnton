<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$fecha_hora = $_POST['fecha_hora'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$mascota_id = $_POST['mascota_id'];
$servicio_id = $_POST['servicio_id'];
$personal_id = $_POST['personal_id'];

try {

  if ($admin->altaAtencion($fecha_hora, $titulo, $descripcion, $mascota_id, $servicio_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Atención registrada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al registrar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: gestion_atenciones.php');
