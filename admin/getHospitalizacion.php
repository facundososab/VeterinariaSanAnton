<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} elseif ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$hospitalizacion_id = $_POST['hospitalizacion_id'];

$hospitalizacion = $admin->getHospitalizacion($hospitalizacion_id);

echo json_encode($hospitalizacion, JSON_UNESCAPED_UNICODE);
