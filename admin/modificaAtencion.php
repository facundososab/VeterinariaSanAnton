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

/***** VALIDACIONES *****/

$errores = [];

if (empty($fecha_hora)) {
  $errores[] = 'Debe ingresar una fecha y hora';
}

if (empty($titulo)) {
  $errores[] = 'Debe ingresar un título';
}

if (empty($descripcion)) {
  $errores[] = 'Debe ingresar una descripción';
}

if (!$admin->atencionExiste($atencion_id)) {
  $errores[] = 'La atención que intenta modificar no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_atenciones.php');
  exit;
}

try {

  if ($admin->modificaAtencion($atencion_id, $fecha_hora, $titulo, $descripcion)) {

    $_SESSION['mensaje'] = 'Atención modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al modificar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: gestion_atenciones.php');
