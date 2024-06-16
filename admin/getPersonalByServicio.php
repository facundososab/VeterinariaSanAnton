<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$servicio_id = $_POST['servicio_id'];

try {

  $personal = $admin->getPersonalByServicioId($servicio_id);
  echo json_encode($personal, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {

  echo json_encode(['error' => $e->getMessage()]);
}
