<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = strtolower($_POST['nombre']);
$foto = strtolower($_POST['foto']);
$raza = strtolower($_POST['raza']);
$color = strtolower($_POST['color']);
$fecha_nac = $_POST['fecha_nac'];
$cliente_id = $_POST['cliente_id'];

try {
  if($admin->altaMascota($nombre, $foto, $raza, $color, $fecha_nac, $cliente_id)){
    $_SESSION['mensaje'] = 'Mascota registrada correctamente';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar la mascota';
  $_SESSION['msg-color'] = 'danger';
  
}

header('Location: ./gestion_mascotas.php');