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
$fecha_hora = $_POST['fecha_hora_modifica'];
$titulo = $_POST['titulo_modifica'];
$descripcion = $_POST['descripcion_modifica'];
$mascota_id = $_POST['mascota_id_modifica'];
$servicio_id = $_POST['servicio_id_modifica'];
$personal_id = $_POST['personal_id_modifica'];
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

if (!$admin->mascotaExiste($mascota_id)) {
  $errores[] = 'La mascota seleccionada no existe';
}

if (!$admin->servicioExiste($servicio_id)) {
  $errores[] = 'El servicio seleccionado no existe';
}

if (!$admin->personalExiste($personal_id)) {
  $errores[] = 'El personal seleccionado no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_atenciones.php');
  exit;
}

try {

  if ($admin->modificaAtencion($atencion_id, $fecha_hora, $titulo, $descripcion, $mascota_id, $servicio_id, $personal_id)) {

    $_SESSION['mensaje'] = 'Atención modificada con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'Error al modificar atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: gestion_atenciones.php');
