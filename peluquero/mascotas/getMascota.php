<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../index.php');
} else if ($_SESSION['rol_id'] != 3) {
  header('Location: ../index.php');
}

require_once '../peluClass.php';

$pelu = new Peluquero();

$mascota_id = $_POST['mascota_id'];

$mascota = $pelu->getMascota($mascota_id);

echo json_encode($mascota, JSON_UNESCAPED_UNICODE);
