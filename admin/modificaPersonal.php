<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$clave = $_POST['clave'];
$personal_id = $_POST['personal_id'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($nombre)) {
  $errores[] = 'Debe ingresar un nombre';
}

if (empty($apellido)) {
  $errores[] = 'Debe ingresar un apellido';
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

if (!$admin->personalExiste($personal_id)) {
  $errores[] = 'El personal que intenta modificar no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_personal.php');
  exit;
}

$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT, ['cost' => 12]);

/***********************/

try {

  if ($personal = $admin->modificaPersonal($personal_id, $nombre, $apellido, $email, $clave_cifrada)) {

    $SESSION['mensaje'] = 'El personal se modificó correctamente';
    $SESSION['msg-color'] = 'success';
  }
} catch (Exception $e) {

  $SESSION['mensaje'] = 'El personal no se pudo modificar';
  $SESSION['msg-color'] = 'danger';
}

header('Location: ./gestion_personal.php');
