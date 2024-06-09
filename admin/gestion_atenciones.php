<?php

session_start();

if (!isset($_SESSION['rol_id'])) {
  header('location: ../index.php');
} else {
  if ($_SESSION['rol_id'] != 1) {
    header('location: ../index.php');
  }
}

require_once 'adminClass.php';
$admin = new Admin();

$tamano_paginas = 8;

if (isset($_GET["pagina"])) {
  $pagina = $_GET["pagina"];
} else {
  $pagina = 1;
}

$total_atenciones = $admin->totalAtenciones();

$empezar_desde = ($pagina - 1) * $tamano_paginas;

$atenciones = $admin->getAllAtenciones($empezar_desde, $tamano_paginas);
