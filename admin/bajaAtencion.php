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

try {
  if ($admin->bajaAtencion($atencion_id)) {
    $_SESSION['mensaje'] = 'Atención dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: gestion_atenciones.php');
