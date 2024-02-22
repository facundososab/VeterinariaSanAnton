<?php
include '../db.php';

class User extends DB{
    public $nombre;
    public $email;

    public $rol_id;


    public function userExists($email, $pass){
        
        $resultado = $this->connect()->prepare('SELECT * FROM clientes WHERE email = :email ');
        $resultado->execute(array(':email' => $email ));

        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            if ($pass==$registro['clave']) {
                return true;
            }
        }

        return false;
        
    }

    public function setUser($email){
        $query = $this->connect()->prepare('SELECT * FROM clientes WHERE email = :email');
        $query->execute([':email' => $email]);
        
        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->email = $currentUser['email'];
            $this->rol_id = $currentUser['rol_id'];
        }
    }

    protected function getNombre(){
        return $this->nombre;
    }

    protected function getRol(){
        return $this->rol_id;

    }
}

?>
