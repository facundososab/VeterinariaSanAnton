<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$atencion_id = $_POST['atencion_id'];
$estado = $_POST['estado'];

$errores = [];

if (empty($atencion_id)) {
  $errores[] = 'El id de la atención no puede estar vacío';
}

if (empty($estado)) {
  $errores[] = 'El estado de la atención no puede estar vacío';
}

if (!in_array($estado, ['PENDIENTE', 'FINALIZADA', 'CANCELADA'])) {
  $errores[] = 'El estado de la atención no es válido';
}




try {
  if (empty($errores) && $vet->actualizaEstadoAtencion($atencion_id, $estado)) {
    $_SESSION['mensaje'] = 'Estado de atención actualizado correctamente';
    $_SESSION['msg-color'] = 'success';
  } else {
    $_SESSION['mensaje'] = 'Error al actualizar el estado de la atención' . $errores;
    $_SESSION['msg-color'] = 'danger';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al actualizar el estado de la atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}


header('Location: ./index.php');
