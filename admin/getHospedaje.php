<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} elseif ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$hospedaje_id = $_POST['hospedaje_id'];

$hospedaje = $admin->getHospedaje($hospedaje_id);
echo json_encode($hospedaje, JSON_UNESCAPED_UNICODE);
