<?php
include_once '../db.php';

if (isset($_POST['enviar'])) {
    session_start();

    try {
        $base = new Database();

        $resultado = $base->connect()->prepare('SELECT * FROM personal WHERE email = :email');

        $email = htmlentities(addslashes($_POST["email"]));
        $clave = htmlentities(addslashes($_POST["password"]));

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
                    header('location:../admin/index.php');
                    exit();
                case 2:
                    header('location:../veterinario/index.php');
                    exit();
                case 3:
                    header('location:../peluquero/index.php');
                    exit();
                default:
                    header('location:../index.php');
                    exit();
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

                header('location:../cliente/index.php');
                exit();
            } else {
                $_SESSION['error'] = "Error. Usuario o contraseña incorrectos";
            }
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Solo incluir el formulario si no hubo redirección
include_once("formulario_login.php");
