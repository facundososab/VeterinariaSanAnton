<?php
ob_start(); // Inicia el buffer de salida
session_start();
include_once '../db.php';

if (isset($_POST['enviar'])) {
    try {
        $base = new Database();

        $resultado = $base->connect()->prepare('SELECT * FROM personal WHERE email = :email');

        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);  // Sanitiza el email
        $clave = htmlentities(addslashes($_POST["password"])); // Sanitiza la contraseña

        $resultado->bindValue(":email", $email);
        $resultado->execute();

        $row = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($clave, $row['clave'])) {
            $_SESSION['id'] = $row['personal_id'];
            $_SESSION['rol_id'] = $row['rol_id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['direccion'] = $row['direccion'];
            $_SESSION['usuario'] = $row['personal_id'];

            switch ($_SESSION['rol_id']) {
                case 1:
                    header('Location: ../admin/index.php');
                    exit;
                case 2:
                    header('Location: ../veterinario/index.php');
                    exit;
                case 3:
                    header('Location: ../peluquero/index.php');
                    exit;
                default:
                    header('Location: ../index.php');
                    exit;
            }
        } else {
            $sql = "SELECT * FROM clientes WHERE email = :email";
            $resultado = $base->connect()->prepare($sql);
            $resultado->bindValue(":email", $email);
            $resultado->execute();
            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($clave, $row['clave'])) {
                $_SESSION['id'] = $row['cliente_id'];
                $_SESSION['rol_id'] = 4;
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['telefono'] = $row['telefono'];
                $_SESSION['direccion'] = $row['direccion'];
                $_SESSION['usuario'] = $row['cliente_id'];

                header('Location: ../cliente/index.php');
                exit;
            } else {
                $_SESSION['error'] = "Error. Usuario o contraseña incorrectos";
            }
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
include_once("formulario_login.php");
?>


</body>

</html>