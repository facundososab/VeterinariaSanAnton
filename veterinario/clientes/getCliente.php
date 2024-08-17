<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';

$vet = new Veterinario();

$cliente_id = $_POST['cliente_id'];

$cliente = $vet->getCliente($cliente_id);

echo json_encode($cliente, JSON_UNESCAPED_UNICODE);
