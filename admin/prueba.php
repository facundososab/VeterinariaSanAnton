<?php
require_once 'adminClass.php';

$admin = new Admin();

$personal = $admin->getPersonalByServicioId(3);

echo json_encode($personal, JSON_UNESCAPED_UNICODE);
