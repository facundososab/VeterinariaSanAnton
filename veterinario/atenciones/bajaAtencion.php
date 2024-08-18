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

try {
  if ($vet->bajaAtencion($atencion_id)) {
    $_SESSION['mensaje'] = 'Atención dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja atención: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: index.php');
