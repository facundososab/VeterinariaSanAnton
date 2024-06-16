<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$cliente_id = $_POST['cliente_id'];

$cliente = $admin->getCliente($cliente_id);

echo json_encode($cliente, JSON_UNESCAPED_UNICODE);
