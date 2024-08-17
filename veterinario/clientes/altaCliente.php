<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$nombre = strtolower($_POST['nombre']);
$apellido = strtolower($_POST['apellido']);
$telefono = $_POST['telefono'];
$ciudad = strtolower($_POST['ciudad']);
$direccion = strtolower($_POST['direccion']);
$email = strtolower($_POST['email']);
$clave = $_POST['clave'];
$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT, ['cost' => 12]);
$rol = 4;

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

if (empty($clave)) {
  $errores[] = 'Debe ingresar una clave';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errores[] = 'El email ingresado no es válido';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}

/*********************/

try {

  if ($vet->altaCliente($nombre, $apellido, $telefono, $email, $clave_cifrada, $ciudad, $direccion, $rol)) {
    $_SESSION['mensaje'] = 'Cliente registrado con éxito';
    $_SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {
  if ($e->getCode() == 23000) {
    $_SESSION['mensaje'] = 'El email ' . $email . ' ya está registrado';
    $_SESSION['msg-color'] = 'danger';
  } else {
    $_SESSION['mensaje'] = 'Error al registrar cliente';
    $_SESSION['msg-color'] = 'danger';
  }
}

header('Location: index.php');
