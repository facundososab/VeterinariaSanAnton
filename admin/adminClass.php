<?php
require_once "../db.php";

class Admin extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllAtenciones()
    {
        $sql = "SELECT * FROM vista_atenciones";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getPersonalId($consulta)
    {
        /* Busca personal por nombre o apellido   */
        $sql = "SELECT * FROM personal WHERE match(nombre, apellido) AGAINST ('$consulta' IN BOOLEAN MODE)";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getClienteId($consulta)
    {
        /* Busca cliente por nombre o apellido   */
        $sql = "SELECT * FROM clientes WHERE match(nombre, apellido) AGAINST ('$consulta' IN BOOLEAN MODE)";
        $result = $this->connect()->query($sql);
        return $result;
    }

    /**************************PERSONAL******************************/

    public function totalPersonal()
    {
        $sql = "SELECT * FROM personal WHERE rol_id != 1";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }


    public function getAllPersonal($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, r.nombre as rol FROM personal p
                INNER JOIN roles r ON p.rol_id = r.rol_id WHERE p.rol_id != 1 LIMIT $empezar_desde,$tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getPersonal($id)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, p.clave, r.nombre as rol FROM personal p  
                INNER JOIN roles r ON p.rol_id = r.rol_id WHERE p.personal_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaPersonal($nombre, $apellido, $email, $clave, $rol_id)
    {
        $sql = "INSERT INTO personal (nombre, apellido, email, clave, rol_id) VALUES (:nombre, :apellido, :email, :clave, :rol_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':clave' => $clave, ':rol_id' => $rol_id));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaPersonal($id)
    {
        $sql = "DELETE FROM personal WHERE personal_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaPersonal($id, $nombre, $apellido, $email, $clave)
    {
        $sql = "UPDATE personal SET nombre = :nombre, apellido = :apellido, email = :email, clave = :clave WHERE personal_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':clave' => $clave, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function personalExiste($nombre, $apellido)
    {
        $sql = "SELECT * FROM personal WHERE nombre = '$nombre' AND apellido = '$apellido'";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**************************CLIENTES******************************/

    public function totalClientes()
    {
        $sql = "SELECT * FROM clientes";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }
    function getAllClientes($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT * FROM clientes LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    function showAllClientes()
    {
        $sql = "SELECT * FROM clientes";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getCliente($id)
    {
        $sql = "SELECT * FROM clientes WHERE cliente_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaCliente($nombre, $apellido, $telefono, $email, $clave, $ciudad, $direccion, $rol_id)
    {
        $sql = "INSERT INTO clientes (nombre, apellido, telefono, email, clave, ciudad, direccion, rol_id) VALUES (:nombre, :apellido, :telefono, :email, :clave, :ciudad, :direccion, :rol_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':apellido' => $apellido, ':telefono' => $telefono, ':email' => $email, ':clave' => $clave, ':ciudad' => $ciudad, ':direccion' => $direccion, ':rol_id' => $rol_id));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaCliente($id)
    {
        $sql = "DELETE FROM clientes WHERE cliente_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaCliente($id, $nombre, $apellido, $email, $telefono, $ciudad, $direccion)
    {
        $sql = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, ciudad = :ciudad, direccion = :direccion WHERE cliente_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':telefono' => $telefono, ':ciudad' => $ciudad, ':direccion' => $direccion, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**************************MASCOTAS******************************/

    public function totalMascotas()
    {
        $sql = "SELECT * FROM mascotas";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }



    public function getAllMascotas($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, m.fecha_nac, m.fecha_muerte, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getMascotaId($nombre, $raza, $fecha_nac, $cliente_id)
    {
        $sql = "SELECT mascota_id FROM mascotas WHERE nombre = :nombre AND raza = :raza AND fecha_nac = :fecha_nac AND cliente_id = :cliente_id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':raza' => $raza, ':fecha_nac' => $fecha_nac, ':cliente_id' => $cliente_id));
        $row = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getMascota($id)
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, m.fecha_nac, m.fecha_muerte, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id WHERE m.mascota_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaMascota($nombre, $raza, $color, $fecha_nac, $cliente_id)
    {
        $sql = "INSERT INTO mascotas (nombre, raza, color, fecha_nac, cliente_id) VALUES (:nombre, :raza, :color, :fecha_nac, :cliente_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':cliente_id' => $cliente_id));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function bajaMascota($id)
    {
        $sql = "DELETE FROM mascotas WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function muerteMascota($id, $fecha)
    {
        $sql = "UPDATE mascotas SET fecha_muerte = :fecha WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha' => $fecha, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaMascota($id, $nombre, $raza, $color, $fecha_nac)
    {
        $sql = "UPDATE mascotas SET nombre = :nombre, raza = :raza, color = :color, fecha_nac = :fecha_nac WHERE mascota_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre,  ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**************************INSUMOS******************************/

    public function totalInsumos()
    {
        $sql = "SELECT * FROM insumos";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }

    public function getAllInsumos($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT * FROM insumos LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getInsumo($id)
    {
        $sql = "SELECT * FROM insumos WHERE insumo_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaInsumo($descripcion, $unidadMedida, $cantidad)
    {
        $sql = "INSERT INTO insumos (descripcion, unidad_medida, cantidad) VALUES (:descripcion, :unidad_medida, :cantidad)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':descripcion' => $descripcion, ':unidad_medida' => $unidadMedida, ':cantidad' => $cantidad));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaInsumo($id)
    {
        $sql = "DELETE FROM insumos WHERE insumo_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaInsumo($id, $descripcion, $unidadMedida, $cantidad)
    {
        $sql = "UPDATE insumos SET descripcion = :descripcion, unidad_medida = :unidad_medida, cantidad = :cantidad WHERE insumo_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':descripcion' => $descripcion, ':unidad_medida' => $unidadMedida, ':cantidad' => $cantidad, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**************************ADMIN******************************/

    public function getAdminInfo()
    {
        $sql = "SELECT * FROM personal WHERE rol_id = 1";
        $result = $this->connect()->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateAdmin($nombre, $apellido, $email)
    {
        $sql = "UPDATE personal SET nombre = :nombre, apellido = :apellido, email = :email WHERE rol_id = 1";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAdminPassword($clave)
    {
        $sql = "UPDATE personal SET clave = :clave WHERE rol_id = 1";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':clave' => $clave]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
