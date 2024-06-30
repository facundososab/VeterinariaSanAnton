<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} elseif ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$mascota_id = $_POST['mascota_id'];

$historia_clinica = $admin->getAtencionesXMascota($mascota_id);

echo json_encode($historia_clinica, JSON_UNESCAPED_UNICODE);
