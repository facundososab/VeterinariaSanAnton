<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 4) {
  header('Location: ../../index.php');
}

require_once '../clienteClass.php';
$cliente = new Cliente();

$mascota_id = $_POST['mascota_id'];

$historia_clinica = $cliente->getAtencionesXMascota($mascota_id);

echo json_encode($historia_clinica, JSON_UNESCAPED_UNICODE);
