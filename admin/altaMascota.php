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
$raza = strtolower($_POST['raza']);
$color = strtolower($_POST['color']);
$fecha_nac = $_POST['fecha_nac'];
$cliente_id = $_POST['cliente_id'];

try {
  if ($admin->altaMascota($nombre, $raza, $color, $fecha_nac, $cliente_id)) {
    $mascota_id = $admin->getMascotaId($nombre, $raza, $fecha_nac, $cliente_id);
    $_SESSION['mensaje'] = 'Mascota registrada correctamente';
    $_SESSION['msg-color'] = 'success';

    if ($_FILES['img_mascota']['error'] == UPLOAD_ERR_OK) {

      $permitidos = array("image/jpg", "image/jpeg");

      if (in_array($_FILES['img_mascota']['type'], $permitidos)) {
        $dir = "../img_mascotas";

        $info_img = pathinfo($_FILES['img_mascota']['name']);


        $imagen = $dir . '/' . $mascota_id . '.jpg';

        if (!file_exists($dir)) {
          mkdir($dir, 0777);
        }

        if (!move_uploaded_file($_FILES['img_mascota']['tmp_name'], $imagen)) {
          $_SESSION['mensaje'] .= '<br>Error al guardar imagen';
          $_SESSION['msg-color'] = 'danger';
        }
      } else {
        $_SESSION['mensaje'] .= '<br>Formato de imágen no permitido' . $_FILES['img_mascota']['type'];
        $_SESSION['msg-color'] = 'danger';
      }
    } else {

      $_SESSION['mensaje'] .= 'Error al subir imagen';
      $_SESSION['msg-color'] = 'danger';
    }
  }
} catch (Exception $e) {
  $_SESSION['mensaje'] = 'Error al registrar la mascota';
  $_SESSION['msg-color'] = 'danger';
}

header('Location: gestion_mascotas.php');
