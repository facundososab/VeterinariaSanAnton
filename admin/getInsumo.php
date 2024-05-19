<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$insumo_id = $_POST['insumo_id'];

$insumo = $admin->getInsumo($insumo_id);

echo json_encode($insumo, JSON_UNESCAPED_UNICODE);
