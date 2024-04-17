<?php

require_once 'adminClass.php';

$admin = new Admin();

$cliente_id = $_POST['cliente_id'];

$cliente = $admin->getCliente($cliente_id);

echo json_encode($cliente, JSON_UNESCAPED_UNICODE);