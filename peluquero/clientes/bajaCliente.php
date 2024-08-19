<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';
$pelu = new Peluquero();

$cliente_id = $_POST['cliente_id'];

try {
  if ($pelu->bajaCliente($cliente_id)) {
    $_SESSION['mensaje'] = 'Cliente dado de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja cliente: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: index.php');
