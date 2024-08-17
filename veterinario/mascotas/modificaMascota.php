<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$mascota_id = $_POST['mascota_id'];
$nombre_mascota = $_POST['nombre'];
$raza = $_POST['raza'];
$color = $_POST['color'];
$fecha_nac = $_POST['fecha_nac'];

/***** VALIDACIONES *****/

$errores = [];

if (empty($nombre_mascota)) {
  $errores[] = 'Debe ingresar un nombre';
}

if (empty($raza)) {
  $errores[] = 'Debe ingresar una raza';
}

if (empty($color)) {
  $errores[] = 'Debe ingresar un color';
}

if (empty($fecha_nac)) {
  $errores[] = 'Debe ingresar una fecha de nacimiento';
}

if (!$vet->mascotaExiste($mascota_id)) {
  $errores[] = 'La mascota que intenta modificar no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: index.php');
  exit;
}


try {
  $_SESSION['mensaje'] = 'Mascota modificada correctamente';
  $_SESSION['msg-color'] = 'success';

  if ($vet->modificaMascota($mascota_id, $nombre_mascota, $raza, $color, $fecha_nac)) {
    if ($_FILES['img_mascota']['error'] == UPLOAD_ERR_OK) {

      $permitidos = array("image/jpg", "image/jpeg");

      if (in_array($_FILES['img_mascota']['type'], $permitidos)) {
        $dir = "../../img_mascotas";

        $info_img = pathinfo($_FILES['img_mascota']['name']);
        $extension = $info_img['extension'];

        $imagen = $dir . '/' . $mascota_id . '.' . $extension;

        if (!file_exists($dir)) {
          mkdir($dir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['img_mascota']['tmp_name'], $imagen)) {
          $_SESSION['mensaje'] .= '<br>Error al guardar imagen';
          $_SESSION['msg-color'] = 'danger';
        }
      } else {
        $_SESSION['mensaje'] .= '<br>Formato de imágen no permitido: ' . $_FILES['img_mascota']['type'] . '. Solo se permiten jpg y jpeg';
        $_SESSION['msg-color'] = 'danger';
      }
    }
  }
} catch (Exception $e) {

  $_SESSION['mensaje'] = 'La mascota no se pudo modificar';
  $_SESSION['msg-color'] = 'danger';
}

header('Location: index.php');
