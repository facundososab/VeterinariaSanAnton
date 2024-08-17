<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$cliente_id = $_POST['cliente_id'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($nombre)) {
  $errores[] = 'Debe ingresar un nombre';
}

if (empty($apellido)) {
  $errores[] = 'Debe ingresar un apellido';
}

if (empty($telefono)) {
  $errores[] = 'Debe ingresar un teléfono';
}

if (empty($ciudad)) {
  $errores[] = 'Debe ingresar una ciudad';
}

if (empty($direccion)) {
  $errores[] = 'Debe ingresar una dirección';
}

if (empty($email)) {
  $errores[] = 'Debe ingresar un email';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errores[] = 'El email ingresado no es válido';
}

if (!$vet->clienteExiste($cliente_id)) {
  $errores[] = 'El cliente no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

try {
  if ($vet->modificaCliente($cliente_id, $nombre, $apellido, $email, $telefono, $ciudad, $direccion)) {
    $_SESSION['mensaje'] = 'Cliente modificado con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al modificar cliente: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('location: index.php');
