<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
} else if ($_SESSION['rol_id'] != 3) {
    header('Location: ../index.php');
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];

require_once 'peluClass.php';
$pelu = new Peluquero();
$pelu_id = $_SESSION['id'];

try {
    $pelu->updatePelu($pelu_id, $nombre, $apellido, $email);
    $_SESSION['mensaje'] = 'Perfil actualizado correctamente';
    $_SESSION['msg-color'] = 'success';
    header('Location: perfil.php');
} catch (Exception $e) {
    $_SESSION['mensaje'] = 'Error al actualizar el perfil';
    $_SESSION['msg-color'] = 'danger';
    header('Location: perfil.php');
}
