<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';
$vet = new Peluquero();

$mascota_id = $_POST['mascota_id'];

$historia_clinica = $vet->getAtencionesXMascota($mascota_id);

echo json_encode($historia_clinica, JSON_UNESCAPED_UNICODE);
