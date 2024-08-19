<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';

$pelu = new Peluquero();

$atencion_id = $_POST['atencion_id'];

$atencion = $pelu->getAtencion($atencion_id);

echo json_encode($atencion, JSON_UNESCAPED_UNICODE);
