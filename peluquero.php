<?php
session_start();

if(!isset($_SESSION['rol_id'])){
    header('location: index.php');
}else{
    if($_SESSION['rol_id'] != 3){
        header('location: index.php');
    }
}

echo "Pagina peluquero";

?>