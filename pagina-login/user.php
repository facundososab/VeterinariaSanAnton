<?php
include '../db.php';

class User extends DB{
    public $nombre;
    public $username;


    public function userExists($user, $pass){
        
        $resultado = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user ');
        $resultado->execute(array(':user' => $user ));

        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($pass, $registro['password'])) {
                return true;
            }
        }

        return false;
        
    }

    public function setUser($user){
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);
        
        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->username = $currentUser['username'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
}

?>
