<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';

$pelu = new Peluquero();

$cliente_id = $_POST['cliente_id'];

$cliente = $pelu->getCliente($cliente_id);

echo json_encode($cliente, JSON_UNESCAPED_UNICODE);
