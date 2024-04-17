<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
}else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$cliente_id = $_POST['cliente_id'];

try {
    if ($admin->modificaCliente($cliente_id, $nombre, $apellido, $email, $telefono, $ciudad, $direccion)) {
    $_SESSION['mensaje'] = 'Cliente modificado con éxito';
    $_SESSION['msg-color'] = 'success';

    }
} catch (Exception $e){
    $_SESSION['mensaje'] = 'Error al modificar cliente: ' . $e->getMessage();
    $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_clientes.php');
