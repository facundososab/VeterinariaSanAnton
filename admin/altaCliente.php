<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = strtolower($_POST['nombre']);
$apellido = strtolower($_POST['apellido']);
$telefono = $_POST['telefono'];
$ciudad = strtolower($_POST['ciudad']);
$direccion = strtolower($_POST['direccion']);
$email = strtolower($_POST['email']);
$clave = $_POST['clave'];
$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT, ['cost' => 12]);
$rol = 4;

try {

  if ($admin->altaCliente($nombre, $apellido, $telefono, $email, $clave_cifrada, $ciudad, $direccion, $rol)) {
    $_SESSION['mensaje'] = 'Cliente registrado con éxito';
    $_SESSION['msg-color'] = 'success';
  } 
} catch (Exception $e) {
  if($e->getCode() == 23000){
    $_SESSION['mensaje'] = 'El email ' . $email . ' ya está registrado';
    $_SESSION['msg-color'] = 'danger';
  }else{
    $_SESSION['mensaje'] = 'Error al registrar cliente';
    $_SESSION['msg-color'] = 'danger';
  }
}

header('Location: gestion_clientes.php');