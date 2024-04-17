<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php');
}else if ($_SESSION['rol_id'] != 1) {
  header('Location: index.php');
}

require_once 'adminClass.php';
$admin = new Admin();

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$clave = $_POST['clave'];
$personal_id = $_POST['personal_id'];


try{

    if($personal = $admin->modificaPersonal($personal_id, $nombre, $apellido, $email, $clave)){

      $SESSION['mensaje'] = 'El personal se modificó correctamente';
      $SESSION['msg-color'] = 'success';

    }

    

  }catch(Exception $e){
    
    $SESSION['mensaje'] = 'El personal no se pudo modificar';
    $SESSION['msg-color'] = 'danger';

}

  header('Location: ./gestion_personal.php');