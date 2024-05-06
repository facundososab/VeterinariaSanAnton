<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$mascota_id = $_POST['id'];

try {
    if ($admin->bajaMascota($mascota_id)) {
    $_SESSION['mensaje'] = 'Mascota dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';

     $dir = "posters";
    $poster = $dir . '/' . $mascota_id . '.jpg';

    if (file_exists($poster)) {
        unlink($poster);
    }


    }
} catch (Exception $e){
    $_SESSION['mensaje'] = 'Error al dar de baja mascota: ' . $e->getMessage();
    $_SESSION['msg-color'] = 'danger';
}

header('Location: ./gestion_mascotas.php');