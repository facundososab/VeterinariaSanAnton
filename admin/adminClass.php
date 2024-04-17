<?php
require_once "../db.php";

class Admin extends Database{

    public function __construct(){
        parent::__construct();
        
    }

    public function getAllAtenciones(){
        $sql = "SELECT * FROM vista_atenciones";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getMascotaId($consulta){
        /* Busca mascota por nombre o raza   */
        $sql = "SELECT * FROM mascotas WHERE match(nombre, raza) AGAINST ('$consulta' IN BOOLEAN MODE)";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getPersonalId($consulta){
        /* Busca personal por nombre o apellido   */
        $sql = "SELECT * FROM personal WHERE match(nombre, apellido) AGAINST ('$consulta' IN BOOLEAN MODE)";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getClienteId($consulta){
        /* Busca cliente por nombre o apellido   */
        $sql = "SELECT * FROM clientes WHERE match(nombre, apellido) AGAINST ('$consulta' IN BOOLEAN MODE)";
        $result = $this->connect()->query($sql);
        return $result;
    }

     /**************************PERSONAL******************************/

    public function getAllPersonal(){
        $sql = "SELECT * FROM personal ORDER BY rol_id ASC";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        return $result;

    }

    public function getPersonal($id){
        $sql = "SELECT * FROM personal WHERE personal_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getPersonalRolName($id){
        $sql = "SELECT * FROM roles WHERE rol_id =:id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['nombre'];
    }

    public function altaPersonal($nombre, $apellido, $email, $clave, $rol_id){
        $sql = "INSERT INTO personal (nombre, apellido, email, clave, rol_id) VALUES (:nombre, :apellido, :email, :clave, :rol_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':clave' => $clave, ':rol_id' => $rol_id));
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function bajaPersonal($id){
        $sql = "DELETE FROM personal WHERE personal_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function modificaPersonal($id, $nombre, $apellido, $email, $clave){
        $sql = "UPDATE personal SET nombre = :nombre, apellido = :apellido, email = :email, clave = :clave WHERE personal_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':clave' => $clave, ':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function personalExiste($nombre, $apellido){
        $sql = "SELECT * FROM personal WHERE nombre = '$nombre' AND apellido = '$apellido'";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if($result->rowCount() > 0){
            return true;

        }else{
            return false;
        }
    }

    /**************************CLIENTES******************************/
    function getAllClientes(){
        $sql = "SELECT * FROM clientes";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        return $result;
    }

    public function getCliente($id){
        $sql = "SELECT * FROM clientes WHERE cliente_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaCliente($nombre, $apellido, $telefono, $email, $clave, $ciudad, $direccion, $rol_id){
        $sql = "INSERT INTO clientes (nombre, apellido, telefono, email, clave, ciudad, direccion, rol_id) VALUES (:nombre, :apellido, :telefono, :email, :clave, :ciudad, :direccion, :rol_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':telefono' => $telefono, ':email' => $email, ':clave' => $clave, ':ciudad' => $ciudad, ':direccion' => $direccion, ':rol_id' => $rol_id));
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function bajaCliente($id){
        $sql = "DELETE FROM clientes WHERE cliente_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function modificaCliente($id, $nombre, $apellido, $email, $telefono, $ciudad, $direccion){
        $sql = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, ciudad = :ciudad, direccion = :direccion WHERE cliente_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':telefono' => $telefono, ':ciudad' => $ciudad, ':direccion' => $direccion, ':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /**************************MASCOTAS******************************/

    public function getAllMascotas(){
        $sql = "SELECT * FROM mascotas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        return $result;
    }

    public function getMascota($id){
        $sql = "SELECT * FROM mascotas WHERE mascota_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaMascota($nombre, $foto, $raza, $color, $fecha_nac,$cliente_id){
        $sql = "INSERT INTO mascotas (nombre, foto, raza, color, fecha_nac, cliente_id) VALUES (:nombre, :foto, :raza, :color, :fecha_nac, :cliente_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':foto' => $foto, ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':cliente_id' => $cliente_id));
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function bajaMascota($id){
        $sql = "DELETE FROM mascotas WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function muerteMascota($id,$fecha){
        $sql = "UPDATE mascotas SET fecha_muerte = :fecha WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha' => $fecha, ':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function modificaMascota($id, $nombre, $foto, $raza, $color, $fecha_nac,$cliente_id){
        $sql = "UPDATE mascotas SET nombre = :nombre, foto = :foto, raza = :raza, color = :color, fecha_nac = :fecha_nac, cliente_id = :cliente_id WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':foto' => $foto, ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':cliente_id' => $cliente_id, ':id' => $id]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
        
    }



    /**************************ADMIN******************************/

    public function getAdminInfo(){
        $sql = "SELECT * FROM personal WHERE rol_id = 1";
        $result = $this->connect()->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateAdmin($nombre, $apellido, $email){
        $sql = "UPDATE personal SET nombre = :nombre, apellido = :apellido, email = :email WHERE rol_id = 1";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updateAdminPassword($clave){
        $sql = "UPDATE personal SET clave = :clave WHERE rol_id = 1";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':clave' => $clave]);
        $sentencia->closeCursor();
        if($sentencia->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }







}