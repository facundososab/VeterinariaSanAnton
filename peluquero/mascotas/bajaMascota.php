<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 3) {
  header('Location: ../../index.php');
}

require_once '../peluClass.php';
$pelu = new Peluquero();

$mascota_id = $_POST['id'];

try {
  if ($pelu->bajaMascota($mascota_id)) {
    $_SESSION['mensaje'] = 'Mascota dada de baja con éxito';
    $_SESSION['msg-color'] = 'success';

    $dir = "../../img_mascotas";
    $poster = $dir . '/' . $mascota_id . '.jpg';

    if (file_exists($poster)) {
      unlink($poster);
    }
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al dar de baja mascota: ' . $e->getMessage();
  $_SESSION['msg-color'] = 'danger';
}

header('Location: ./index.php');
