<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
} else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$mascota_id = $_POST['mascota_id'];
$nombre_mascota = $_POST['nombre'];
$raza = $_POST['raza'];
$color = $_POST['color'];
$fecha_nac = $_POST['fecha_nac'];


try {

  if ($mascota = $admin->modificaMascota($mascota_id, $nombre_mascota, $raza, $color, $fecha_nac)) {

    $_SESSION['mensaje'] = 'La mascota se modificó correctamente';
    $_SESSION['msg-color'] = 'success';

    $imagen = $_FILES['img_mascota']['name'];

    if (isset($imagen)) {

      if ($_FILES['img_mascota']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg");
        if (in_array($_FILES['img_mascota']['type'], $permitidos)) {

          $dir = "img_mascotas";

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
          $_SESSION['mensaje'] = '<br>Formato de imágen no permitido';
          $_SESSION['msg-color'] = 'danger';
        }
      } else {

        $_SESSION['mensaje'] = 'Error al subir imagen';
        $_SESSION['msg-color'] = 'danger';
      }
    }
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'La mascota no se pudo modificar';
  $_SESSION['msg-color'] = 'danger';
}

header('Location: ./gestion_mascotas.php');
