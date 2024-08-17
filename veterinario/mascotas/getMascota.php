<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../index.php');
}

require_once '../vetClass.php';

$vet = new Veterinario();

$mascota_id = $_POST['mascota_id'];

$mascota = $vet->getMascota($mascota_id);

echo json_encode($mascota, JSON_UNESCAPED_UNICODE);
