<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$rol_id = $_POST['rol_id'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($nombre)) {
  $errores[] = 'Debe ingresar un nombre';
}

if (empty($precio)) {
  $errores[] = 'Debe ingresar un precio';
}

if (!is_numeric($precio)) {
  $errores[] = 'El precio debe ser un número valido. Si el precio es decimal, utilice el punto como separador de decimales.';
}

if ($precio < 0) {
  $errores[] = 'El precio no puede ser negativo';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_servicios.php');
  exit;
}

try {
  if ($admin->altaServicio($nombre, $tipo, $precio, $rol_id)) {
    $_SESSION['mensaje'] = 'Servicio registrado con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar servicio: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_servicios.php');
