<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$mascota_id = $_POST['mascota_id'];

$mascota = $admin->getMascota($mascota_id);

echo json_encode($mascota, JSON_UNESCAPED_UNICODE);
