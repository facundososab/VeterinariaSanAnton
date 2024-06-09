<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$insumo_id = $_POST['insumo_id'];
$descripcion = $_POST['descripcion'];
$unidad_medida = $_POST['unidad_medida'];
$cantidad = $_POST['cantidad'];

try {

  if ($admin->modificaInsumo($insumo_id, $descripcion, $unidad_medida, $cantidad)) {
    $_SESSION['mensaje'] = 'Insumo registrado con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar insumo: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_insumos.php');
