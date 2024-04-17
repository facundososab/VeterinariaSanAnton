<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
}else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';

$admin = new Admin();

$nombre = strtolower($_POST['nombre']);
$apellido = strtolower($_POST['apellido']);
$email = strtolower($_POST['email']);
$clave = $_POST['clave'];
$clave_cifrada = password_hash($clave, PASSWORD_DEFAULT, ['cost' => 12]);
$rol = $_POST['rol'];

try{ 

  if($admin->altaPersonal($nombre, $apellido, $email, $clave_cifrada, $rol)){
  
  $_SESSION['mensaje'] = 'Personal registrado con éxito';
  $_SESSION['msg-color'] = 'success';

}

}catch(Exception $e){

  $_SESSION['mensaje'] = 'Error al registrar personal: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
  

}

header('location: ./gestion_personal.php');  




