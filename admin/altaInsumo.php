<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$descripcion = $_POST['descripcion'];
$unidad_medida = $_POST['unidad_medida'];
$cantidad = $_POST['cantidad'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($descripcion)) {
  $errores[] = 'Debe ingresar una descripción';
}

if (empty($unidad_medida)) {
  $errores[] = 'Debe ingresar una unidad de medida';
}

if (empty($cantidad)) {
  $errores[] = 'Debe ingresar una cantidad';
}

if (!is_numeric($cantidad)) {
  $errores[] = 'La cantidad debe ser un número';
}

if ($cantidad < 0) {
  $errores[] = 'La cantidad no puede ser negativa';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_insumos.php');
  exit;
}

try {

  if ($admin->altaInsumo($descripcion, $unidad_medida, $cantidad)) {
    $_SESSION['mensaje'] = 'Insumo registrado con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  if ($e->getCode() == 23000) {
    $_SESSION['mensaje'] = 'El insumo ' . $descripcion . ' ya está registrado';
    $_SESSION['msg-color'] = 'danger';
  } else {
    $_SESSION['mensaje'] = 'Error al registrar insumo';
    $_SESSION['msg-color'] = 'danger';
  }
}

header('Location: gestion_insumos.php');
