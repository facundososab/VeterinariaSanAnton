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

try {
  if ($admin->bajaInsumo($insumo_id)) {
    $_SESSION['mensaje'] = 'Insumo dado de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja insumo: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_insumos.php');
