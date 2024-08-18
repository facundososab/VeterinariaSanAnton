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

$atencion = $vet->getAtencion($atencion_id);

echo json_encode($atencion, JSON_UNESCAPED_UNICODE);
