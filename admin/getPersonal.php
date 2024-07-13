<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$personal_id = $_POST['personal_id'];

$personal = $admin->getPersonal($personal_id);

echo json_encode($personal, JSON_UNESCAPED_UNICODE);
