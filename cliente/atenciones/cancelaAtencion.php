<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 4) {
  header('Location: ../../index.php');
}

require_once '../clienteClass.php';
$cliente = new Cliente();

$atencion_id = $_POST['atencion_id'];

$errores = [];

if (empty($atencion_id)) {
  $errores[] = 'El id de la atención no puede estar vacío';
}





try {
  if (empty($errores) && $cliente->cancelaAtencion($atencion_id)) {
    $_SESSION['mensaje'] = 'Atención cancelada correctamente';
    $_SESSION['msg-color'] = 'success';
  } else {
    $_SESSION['mensaje'] = 'Error al cancelar la atención' . $errores;
    $_SESSION['msg-color'] = 'danger';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al cancelar la atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}


header('Location: index.php');
