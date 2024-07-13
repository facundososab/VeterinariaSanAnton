<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$atencion_id = $_POST['atencion_id'];

$atencion = $admin->getAtencion($atencion_id);

echo json_encode($atencion, JSON_UNESCAPED_UNICODE);
