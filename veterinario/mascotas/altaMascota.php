<?php

session_start();

require_once '../vetClass.php';
$vet = new Veterinario();

/***************** VALIDACIONES ***************/

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} else if ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

$nombre = strtolower($_POST['nombre']);
$raza = strtolower($_POST['raza']);
$color = strtolower($_POST['color']);
$fecha_nac = $_POST['fecha_nac'];
$cliente_id = $_POST['cliente_id'];

$errores = [];

if (empty($nombre)) {
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

if (empty($cliente_id)) {
  $errores[] = 'Debe seleccionar un cliente';
}

if (!$vet->clienteExiste($cliente_id)) {
  $errores[] = 'El cliente seleccionado no existe';
}

if (count($errores) > 0) {
  $_SESSION['mensaje'] = implode('<br>', $errores);
  $_SESSION['msg-color'] = 'danger';
  header('Location: ./gestion_mascotas.php');
  exit;
}

/***************************************************/

$mascota_id = $vet->altaMascota($nombre, $raza, $color, $fecha_nac, $cliente_id);

try {
  if ($mascota_id) {
    $_SESSION['mensaje'] = 'Mascota registrada correctamente';
    $_SESSION['msg-color'] = 'success';

    if ($_FILES['img_mascota']['error'] == UPLOAD_ERR_OK && $_FILES['img_mascota']['size'] > 0) {

      $permitidos = array("image/jpg", "image/jpeg");

      if (in_array($_FILES['img_mascota']['type'], $permitidos)) {
        $dir = "../img_mascotas";

        $info_img = pathinfo($_FILES['img_mascota']['name']);
        $extension = $info_img['extension'];

        $imagen = $dir . '/' . $mascota_id . '.' . $extension;

        if (!file_exists($dir)) {
          mkdir($dir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['img_mascota']['tmp_name'], $imagen)) {
          $_SESSION['mensaje'] .= '<br>';
          $_SESSION['mensaje'] .= 'Error al guardar imagen';
          $_SESSION['msg-color'] = 'danger';
        }
      } else {
        $_SESSION['mensaje'] .= '<br>Formato de imágen no permitido: ' . $_FILES['img_mascota']['type'] . '. Solo se permiten jpg y jpeg';
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

header('Location: index.php');
