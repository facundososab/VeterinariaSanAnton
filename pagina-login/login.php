<?php
    include_once './db.php';

    session_start();

    if(isset($_GET['cerrar_sesion'])){
        session_unset();

        session_destroy();
        
        header('../location:index.php');
    }

    if(isset($_SESSION['usuario'])){

        header('../location:index.php');

    }else if(isset($_POST['enviar'])){
      
        try {
        $base = new PDO("mysql:host=localhost; dbname=veterinaria", "root", "");

        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM personal WHERE email = :email AND clave = :clave";

        $resultado = $base->prepare($sql);

        $email = htmlentities(addslashes($_POST["email"]));

        $clave = htmlentities(addslashes($_POST["password"]));

        $resultado->bindValue(":email", $email);
        $resultado->bindValue(":clave", $clave);

        $resultado->execute();

        $row = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $rol = $row['rol'];
            $_SESSION['rol_id'] = $rol;

            switch($_SESSION['rol_id']){
                case 1:
                header('location:../admin.php');
                break;
    
                case 2:
                header('location:../veterinario.php');
                break;
                case 3:
                header('location:../peluquero.php');
                break;

                case 4:
                header('location:../cliente.php');
                break;
    
                default:
                header('location:../index.php');
            }

        } else {
            //Redirige al login
            //header("location:login.php");

            echo "Error. Usuario o contraseña incorrecta.";
        }

    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }

        /* $db = new Database();
        $query = $db->connect()->prepare('SELECT * FROM personal WHERE email = :email AND clave = :clave');
        $query->execute(['email' => $email, 'clave' => $password]);

        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($row){
            // validar rol
            $rol = $row['rol_id'];
            $_SESSION['rol_id'] = $rol;

            switch($_SESSION['rol_id']){
                case 1:
                header('../location:admin.php');
                break;
    
                case 2:
                header('../location:veterinario.php');
                break;
                
                case 3:
                header('../location:peluquero.php');
                break;

                case 4:
                header('../location:cliente.php');
                break;
    
                default:
                header('location:index.php');
            }
        }else{
            // no existe el usuario
            echo "El usuario o contraseña son incorrectos";
        }  */

    }else{
    
    include_once("formulario_login.php");
}

?>

    
</body>
</html>
