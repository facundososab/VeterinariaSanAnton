<?php

/*
 * Este archivo consulta los datos del registro y los retorna en formato JSON 
 */

require_once 'adminClass.php';

$admin = new Admin();

$mascota_id = $_POST['mascota_id'];

$mascota = $admin->getMascota($mascota_id);

echo json_encode($mascota, JSON_UNESCAPED_UNICODE);
