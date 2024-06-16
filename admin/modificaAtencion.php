<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$atencion_id = $_POST['atencion_id'];
$fecha_hora = $_POST['fecha_hora'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$mascota_id = $_POST['mascota_id'];
$servicio_id = $_POST['servicio_id'];
$personal_id = $_POST['personal_id'];

try {

  if ($admin->modificaAtencion($atencion_id, $fecha_hora, $titulo, $descripcion)) {

    $_SESSION['mensaje'] = 'Atención modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al modificar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}
