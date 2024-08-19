<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 4) {
  header('Location: ../../index.php');
}

require_once '../clienteClass.php';

$cliente = new Cliente();

$mascota_id = $_POST['mascota_id'];

$mascota = $cliente->getMascota($mascota_id);

echo json_encode($mascota, JSON_UNESCAPED_UNICODE);
