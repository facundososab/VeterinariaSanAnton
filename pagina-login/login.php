<?php
    include_once '../db.php';;

    if(isset($_POST['enviar'])){
        session_start();

        try {
        $base = new Database();

        $resultado = $base->connect()->prepare('SELECT * FROM personal WHERE email = :email AND clave = :clave');

        $email = htmlentities(addslashes($_POST["email"]));

        $clave = htmlentities(addslashes($_POST["password"]));

        $resultado->bindValue(":email", $email);
        $resultado->bindValue(":clave", $clave);

        $resultado->execute();

        $row = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['rol_id'] = $row['rol_id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['direccion'] = $row['direccion'];
            $_SESSION['usuario'] = $row['personal_id'];

            switch($_SESSION['rol_id']){
                case 1:
                header('location:../admin/index.php');
                break;
    
                case 2:
                header('location:../veterinario/index.php');
                break;
                case 3:
                header('location:../peluquero/index.php');
                break;
    
                default:
                header('location:../index.php');
            }

        } else {
            $sql = "SELECT * FROM clientes WHERE email = :email AND clave = :clave";

            $resultado = $base->connect()->prepare($sql);

            $email = htmlentities(addslashes($_POST["email"]));

            $clave = htmlentities(addslashes($_POST["password"]));

            $resultado->bindValue(":email", $email);
            $resultado->bindValue(":clave", $clave);

            $resultado->execute();

            $row = $resultado->fetch(PDO::FETCH_ASSOC);


            //Redirige al login
            //header("location:login.php");
            if ($row) {
                $_SESSION['rol_id'] = 4;
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['telefono'] = $row['telefono'];
                $_SESSION['direccion'] = $row['direccion'];
                $_SESSION['usuario'] = $row['cliente_id'];
                
                header('location:../cliente/index.php');


            } else {

                echo "Error. Usuario o contraseña incorrecta.";

            }
        }

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }

    }else{
    include_once("formulario_login.php");
}

?>

    
</body>
</html>
