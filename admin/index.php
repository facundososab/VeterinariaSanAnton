<?php

session_start();

if(!isset($_SESSION['rol_id'])){
    header('location: ../index.php');
} else {
    if ($_SESSION['rol_id'] != 1) {
        header('location: ../index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'head.html';?> 
<body>
   <?php include_once 'header.html';?>


 <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>

    
</body>
</html>