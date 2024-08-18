<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: ../../index.php');
} elseif ($_SESSION['rol_id'] != 2) {
  header('Location: ../../index.php');
}

require_once '../vetClass.php';
$vet = new Veterinario();

$hospitalizacion_id = $_POST['hospitalizacion_id'];

$hospitalizacion = $vet->getHospitalizacion($hospitalizacion_id);

echo json_encode($hospitalizacion, JSON_UNESCAPED_UNICODE);
