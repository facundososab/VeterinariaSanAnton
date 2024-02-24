<?php

session_start();

if(!isset($_SESSION['rol_id'])){
    header('location: index.php');
}else{
    if($_SESSION['rol_id'] != 1){
        header('location: index.php');
    }
}



echo "Pagina administrador";

?>

<!DOCTYPE html>
<html lang="en">
<?php
include_once('./inc/head.php');
?>
<body>
    <?php
    include_once('./inc/header.php');
    ?>

    



    
</body>
</html>