<?php

/*
 * Este archivo consulta los datos del registro y los retorna en formato JSON 
 */

require_once 'adminClass.php';

$admin = new Admin();

$personal_id = $_POST['personal_id'];

$personal = $admin->getPersonal($personal_id);

echo json_encode($personal, JSON_UNESCAPED_UNICODE);

