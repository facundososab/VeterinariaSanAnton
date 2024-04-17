<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$personal_id = $_POST['id'];

try {
    if ($admin->bajaPersonal($personal_id)) {
    $_SESSION['mensaje'] = 'Personal dado de baja con éxito';
    $_SESSION['msg-color'] = 'success';

    }
} catch (Exception $e){
    $_SESSION['mensaje'] = 'Error al dar de baja personal: ' . $e->getMessage();
    $_SESSION['msg-color'] = 'danger';
}

header('location: ./gestion_personal.php');