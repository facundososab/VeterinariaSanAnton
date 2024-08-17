<?php
require_once "../db.php";

class Admin extends Database
{

    public function __construct()
    {
        parent::__construct();
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
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, r.nombre as rol 
                FROM personal p
                INNER JOIN roles r ON p.rol_id = r.rol_id 
                WHERE p.rol_id != 1 
                LIMIT $empezar_desde,$tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function totalPersonalXBusqueda($nombreOEmail)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, r.nombre as rol 
                FROM personal p
                INNER JOIN roles r ON p.rol_id = r.rol_id 
                WHERE p.rol_id != 1 AND (p.nombre LIKE :nombreOEmail OR p.email LIKE :nombreOEmail)";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOEmail . '%';
        $result->bindValue(':nombreOEmail', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return count($data);
        } else {
            return 0;
        }
    }
    public function getPersonalXBusqueda($nombreOEmail, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, r.nombre as rol 
                FROM personal p
                INNER JOIN roles r ON p.rol_id = r.rol_id 
                WHERE p.rol_id != 1 AND (p.nombre LIKE :nombreOEmail OR p.email LIKE :nombreOEmail)
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOEmail . '%';
        $result->bindValue(':nombreOEmail', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function getPersonal($id)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email, p.clave, r.nombre as rol 
                FROM personal p  
                INNER JOIN roles r ON p.rol_id = r.rol_id 
                WHERE p.personal_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getPersonalByServicioId($servicio_id)
    {
        $sql = "SELECT p.personal_id, p.nombre, p.apellido, p.email 
                FROM personal p
                INNER JOIN servicios s ON p.rol_id = s.rol_id 
                WHERE s.servicio_id = :servicio_id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':servicio_id' => $servicio_id]);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
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

    public function personalExiste($id)
    {
        $sql = "SELECT * FROM personal WHERE personal_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
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
    public function getAllClientes($empezar_desde, $tamano_paginas)
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

    public function totalClientesXBusqueda($nombreOEmail)
    {
        $sql = "SELECT * FROM clientes WHERE nombre LIKE :nombreOEmail OR email LIKE :nombreOEmail";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOEmail . '%';
        $result->bindValue(':nombreOEmail', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return count($data);
        } else {
            return 0;
        }
    }

    public function getClientesXBusqueda($nombreOEmail, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT * FROM clientes 
                WHERE nombre LIKE :nombreOEmail OR email LIKE :nombreOEmail 
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOEmail . '%';
        $result->bindValue(':nombreOEmail', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function showAllClientes()
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

    public function clienteExiste($id)
    {
        $sql = "SELECT * FROM clientes WHERE cliente_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $result->closeCursor();
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**************************MASCOTAS******************************/

    public function totalMascotas()
    {
        $sql = "SELECT * FROM mascotas m WHERE m.fecha_muerte IS NULL";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }


    public function getAllMascotas($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, DATE_FORMAT(m.fecha_nac, '%d/%m/%Y') as fecha_nac, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email 
                FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id 
                WHERE m.fecha_muerte IS NULL 
                LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function totalMascotasByNombreORaza($nombreORaza)
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, m.fecha_nac, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email 
                FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id 
                WHERE m.fecha_muerte IS NULL AND m.nombre LIKE :nombreORaza OR m.raza LIKE :nombreORaza";
        $result = $this->connect()->prepare($sql);

        $searchTerm = '%' . $nombreORaza . '%';
        $result->bindValue(':nombreORaza', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            return count($data);
        } else {
            return 0;
        }
    }

    public function getMascotasByNombreORaza($nombreORaza, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, DATE_FORMAT(m.fecha_nac, '%d/%m/%Y') as fecha_nac, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email 
                FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id 
                WHERE m.fecha_muerte IS NULL AND m.nombre LIKE :nombreORaza OR m.raza LIKE :nombreORaza
                LIMIT :empezar_desde, :tamano_paginas";

        $result = $this->connect()->prepare($sql);

        // Bind parameters
        $searchTerm = '%' . $nombreORaza . '%';
        $result->bindValue(':nombreORaza', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return [];
        }
    }



    public function showAllMascotasConCliente()
    {
        $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, m.fecha_nac, m.fecha_muerte, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id";
        $result = $this->connect()->query($sql);
        return $result;
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
        $conexion = $this->connect();
        $sql = "INSERT INTO mascotas (nombre, raza, color, fecha_nac, cliente_id) VALUES (:nombre, :raza, :color, :fecha_nac, :cliente_id)";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':cliente_id' => $cliente_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return $conexion->lastInsertId();
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
        try {
            $sql = "UPDATE mascotas SET nombre = :nombre, raza = :raza, color = :color, fecha_nac = :fecha_nac WHERE mascota_id = :id";
            $sentencia = $this->connect()->prepare($sql);
            $sentencia->execute([':nombre' => $nombre,  ':raza' => $raza, ':color' => $color, ':fecha_nac' => $fecha_nac, ':id' => $id]);
            $sentencia->closeCursor();
            //Devuelvo un true por si la modificacion se ejecuto bien pero no se modifico nada ya que el rowCount devolveria 0. Para el caso de subir imagen
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function mascotaExiste($id)
    {
        $sql = "SELECT * FROM mascotas WHERE mascota_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
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

    public function totalInsumosXBusqueda($descripcion)
    {
        $sql = "SELECT * FROM insumos WHERE descripcion LIKE :descripcion";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $descripcion . '%';
        $result->bindValue(':descripcion', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result->rowCount();
        } else {
            return 0;
        }
    }

    public function getInsumosXBusqueda($descripcion, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT * FROM insumos WHERE descripcion LIKE :descripcion LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $descripcion . '%';
        $result->bindValue(':descripcion', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
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

    public function insumoExiste($id)
    {
        $sql = "SELECT * FROM insumos WHERE insumo_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
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

    /**************************SERVICIOS******************************/
    public function totalServicios()
    {
        $sql = "SELECT * FROM servicios WHERE activo = 1";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }

    public function getAllServicios($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT s.servicio_id, s.nombre, s.tipo, s.precio, r.nombre as rol 
                FROM servicios s
                INNER JOIN roles r ON s.rol_id = r.rol_id
                WHERE s.activo = 1 
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function totalServiciosXBusqueda($nombreOTipo)
    {
        $sql = "SELECT s.servicio_id, s.nombre, s.tipo, s.precio, r.nombre as rol 
                FROM servicios s
                INNER JOIN roles r ON s.rol_id = r.rol_id
                WHERE s.activo = 1 AND (s.nombre LIKE :nombreOTipo OR s.tipo LIKE :nombreOTipo)";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOTipo . '%';
        $result->bindValue(':nombreOTipo', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return count($data);
        } else {
            return 0;
        }
    }

    public function getServiciosXBusqueda($nombreOTipo, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT s.servicio_id, s.nombre, s.tipo, s.precio, r.nombre as rol 
                FROM servicios s
                INNER JOIN roles r ON s.rol_id = r.rol_id
                WHERE s.activo = 1 AND (s.nombre LIKE :nombreOTipo OR s.tipo LIKE :nombreOTipo)
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $nombreOTipo . '%';
        $result->bindValue(':nombreOTipo', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function showAllServicios()
    {
        $sql = "SELECT * FROM servicios WHERE activo = 1";
        $result = $this->connect()->query($sql);
        return $result;
    }

    public function getServicio($id)
    {
        $sql = "SELECT * FROM servicios WHERE servicio_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaServicio($nombre, $tipo, $precio, $rol_id)
    {
        $sql = "INSERT INTO servicios (nombre, tipo, precio, rol_id) VALUES (:nombre, :tipo, :precio, :rol_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':nombre' => $nombre, ':tipo' => $tipo, ':precio' => $precio, ':rol_id' => $rol_id));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaServicio($id)
    {
        $sql = "UPDATE servicios SET activo = 0 WHERE servicio_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaServicio($id, $nombre, $tipo, $precio, $rol_id)
    {
        $sql = "UPDATE servicios SET nombre = :nombre, tipo = :tipo, precio = :precio, rol_id = :rol_id WHERE servicio_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':nombre' => $nombre, ':tipo' => $tipo, ':precio' => $precio, ':id' => $id, ':rol_id' => $rol_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function servicioExiste($id)
    {
        $sql = "SELECT * FROM servicios WHERE servicio_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



    /**************************ATENCIONES******************************/

    public function totalAtenciones()
    {
        $sql = "SELECT * FROM atenciones";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }

    public function getAllAtenciones($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    a.atencion_id, 
                    DATE_FORMAT(a.fecha_hora, '%d/%m/%Y %H:%i:%s') as fecha_hora, 
                    a.titulo, 
                    a.descripcion, 
                    a.estado, 
                    m.nombre as mascota_nombre,  
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido, 
                    c.nombre as cliente_nombre, 
                    c.apellido as cliente_apellido, 
                    s.nombre as servicio_nombre 
                FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function totalAtencionesXBusqueda($filtro)
    {
        $sql = "SELECT 
                    count(*) as total
                FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id
                WHERE (a.titulo LIKE :filtro OR a.descripcion LIKE :filtro OR m.nombre LIKE :filtro OR m.raza LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro OR c.nombre LIKE :filtro OR c.apellido LIKE :filtro OR s.nombre LIKE :filtro)";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return $data['total'];
        } else {
            return 0;
        }
    }

    public function getAtencionesXBusqueda($filtro, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    a.atencion_id, 
                    DATE_FORMAT(a.fecha_hora, '%d/%m/%Y %H:%i:%s') as fecha_hora, 
                    a.titulo, 
                    a.descripcion, 
                    a.estado, 
                    m.nombre as mascota_nombre, 
                    m.fecha_muerte as mascota_fecha_muerte, 
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido, 
                    c.nombre as cliente_nombre, 
                    c.apellido as cliente_apellido, 
                    s.nombre as servicio_nombre 
                FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id
                WHERE (a.titulo LIKE :filtro OR a.descripcion LIKE :filtro OR m.nombre LIKE :filtro OR m.raza LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro OR c.nombre LIKE :filtro OR c.apellido LIKE :filtro OR s.nombre LIKE :filtro)
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function getAtencionesHoy()
    {
        $sql = "SELECT a.atencion_id, a.fecha_hora, a.titulo, a.descripcion, m.nombre as mascota_nombre, m.raza, p.nombre as personal_nombre, p.apellido as personal_apellido, c.nombre as cliente_nombre, c.apellido as cliente_apellido, s.nombre as servicio_nombre FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id 
                WHERE DATE(a.fecha_hora) = CURDATE() AND a.estado = 'PENDIENTE'";
        $result = $this->connect()->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getAtencion($id)
    {
        $sql = "SELECT a.atencion_id, a.fecha_hora, a.titulo, a.descripcion, m.mascota_id, m.nombre as mascota_nombre, m.raza, p.personal_id, p.nombre as personal_nombre, p.apellido as personal_apellido, c.nombre as cliente_nombre, c.apellido as cliente_apellido, s.servicio_id, s.nombre as servicio_nombre FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id WHERE a.atencion_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getAtencionesXMascota($mascota_id)
    {
        $sql = "SELECT a.atencion_id, a.fecha_hora, a.titulo, a.descripcion, p.nombre as personal_nombre, p.apellido as personal_apellido, s.nombre as servicio_nombre FROM atenciones a
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id WHERE a.mascota_id = :mascota_id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':mascota_id' => $mascota_id]);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaAtencion($fecha_hora, $titulo, $descripcion, $mascota, $servicio, $personal)
    {
        $sql = "INSERT INTO atenciones (fecha_hora, titulo, descripcion, mascota_id, servicio_id, personal_id) VALUES (:fecha_hora, :titulo, :descripcion, :mascota, :servicio, :personal)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':fecha_hora' => $fecha_hora, ':titulo' => $titulo, ':descripcion' => $descripcion, ':mascota' => $mascota, ':servicio' => $servicio, ':personal' => $personal));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaAtencion($id)
    {
        $sql = "DELETE FROM atenciones WHERE atencion_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaAtencion($id, $fecha_hora, $titulo, $descripcion, $mascota_id, $servicio_id, $personal_id)
    {
        $sql = "UPDATE atenciones SET fecha_hora = :fecha_hora, titulo = :titulo, descripcion = :descripcion, mascota_id = :mascota_id, servicio_id = :servicio_id, personal_id = :personal_id WHERE atencion_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha_hora' => $fecha_hora, ':titulo' => $titulo, ':descripcion' => $descripcion, ':mascota_id' => $mascota_id, ':servicio_id' => $servicio_id, ':personal_id' => $personal_id, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizaEstadoAtencion($atencion_id, $estado)
    {
        $sql = "UPDATE atenciones SET estado = :estado WHERE atencion_id = :atencion_id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':estado' => $estado, ':atencion_id' => $atencion_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function atencionExiste($id)
    {
        $sql = "SELECT * FROM atenciones WHERE atencion_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**************************HOSPITALIZACIONES******************************/

    public function totalHospitalizaciones()
    {
        $sql = "SELECT * FROM hospitalizaciones";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }

    public function getAllHospitalizaciones($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    h.hospitalizacion_id, 
                    DATE_FORMAT(h.fecha_hora_ingreso, '%d/%m/%Y %H:%i:%s') as fecha_hora_ingreso, 
                    h.motivo, 
                    DATE_FORMAT(h.fecha_hora_alta, '%d/%m/%Y %H:%i:%s') as fecha_hora_alta, 
                    h.observaciones, 
                    m.nombre as mascota_nombre, 
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido, 
                    c.nombre as cliente_nombre, 
                    c.apellido as cliente_apellido 
                FROM hospitalizaciones h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id 
                LIMIT $empezar_desde, $tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function totalHospitalizacionesXBusqueda($filtro)
    {
        $sql = "SELECT 
                    count(*) as total
                FROM hospitalizaciones h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE (m.nombre LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro OR c.nombre LIKE :filtro OR c.apellido LIKE :filtro)";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return $data['total'];
        } else {
            return 0;
        }
    }

    public function getHospitalizacionesXBusqueda($filtro, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    h.hospitalizacion_id, 
                    DATE_FORMAT(h.fecha_hora_ingreso, '%d/%m/%Y %H:%i:%s') as fecha_hora_ingreso, 
                    h.motivo, 
                    DATE_FORMAT(h.fecha_hora_alta, '%d/%m/%Y %H:%i:%s') as fecha_hora_alta, 
                    h.observaciones, 
                    m.nombre as mascota_nombre, 
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido, 
                    c.nombre as cliente_nombre, 
                    c.apellido as cliente_apellido 
                FROM hospitalizaciones h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE (m.nombre LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro OR c.nombre LIKE :filtro OR c.apellido LIKE :filtro)
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function getHospitalizacion($id)
    {
        $sql = "SELECT h.hospitalizacion_id, h.fecha_hora_ingreso, h.motivo, h.fecha_hora_alta, h.observaciones, m.mascota_id, m.nombre as mascota_nombre, m.raza, p.personal_id, p.nombre as personal_nombre, p.apellido as personal_apellido, c.nombre as cliente_nombre, c.apellido as cliente_apellido FROM hospitalizaciones h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id WHERE h.hospitalizacion_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getHospitalizacionesXMascota($mascota_id)
    {
        $sql = "SELECT h.hospitalizacion_id, h.fecha_hora_ingreso, h.fecha_hora_alta, h.titulo, h.observaciones, p.nombre as personal_nombre, p.apellido as personal_apellido FROM hospitalizaciones h
                INNER JOIN personal p ON h.personal_id = p.personal_id WHERE h.mascota_id = :mascota_id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':mascota_id' => $mascota_id]);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaHospitalizacion($fecha_hora_ingreso, $motivo, $mascota_id, $personal_id)
    {
        $sql = "INSERT INTO hospitalizaciones (fecha_hora_ingreso, motivo, mascota_id, personal_id) VALUES (:fecha_hora_ingreso, :motivo, :mascota_id, :personal_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute(array(':fecha_hora_ingreso' => $fecha_hora_ingreso, ':motivo' => $motivo, ':mascota_id' => $mascota_id, ':personal_id' => $personal_id));
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function altaSalidaHospitalizacion($observaciones, $hospitalizacion_id)
    {
        $sql = "UPDATE hospitalizaciones SET fecha_hora_alta = :fecha_hora_alta, observaciones = :observaciones WHERE hospitalizacion_id = :hospitalizacion_id";
        $sentencia = $this->connect()->prepare($sql);
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $sentencia->execute([':fecha_hora_alta' => date('Y-m-d H:i:s'), ':observaciones' => $observaciones, ':hospitalizacion_id' => $hospitalizacion_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function bajaHospitalizacion($id)
    {
        $sql = "DELETE FROM hospitalizaciones WHERE hospitalizacion_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaHospitalizacion($id, $fecha_hora_ingreso, $motivo, $mascota_id, $personal_id)
    {
        $sql = "UPDATE hospitalizaciones SET fecha_hora_ingreso = :fecha_hora_ingreso, motivo = :motivo, mascota_id = :mascota_id, personal_id = :personal_id WHERE hospitalizacion_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha_hora_ingreso' => $fecha_hora_ingreso, ':motivo' => $motivo, ':mascota_id' => $mascota_id, ':personal_id' => $personal_id, ':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function hospitalizacionExiste($id)
    {
        $sql = "SELECT * FROM hospitalizaciones WHERE hospitalizacion_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function showAllVeterinarios()
    {
        $sql = "SELECT * FROM personal WHERE rol_id = 2";
        $result = $this->connect()->query($sql);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    /**************************HOTELERIA******************************/

    public function totalHospedajes()
    {
        $sql = "SELECT * FROM hoteleria";
        $result = $this->connect()->query($sql);
        $row = $result->rowCount();
        return $row;
    }

    public function getAllHospedajes($empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    h.hospedaje_id, 
                    DATE_FORMAT(h.fecha_hora_ingreso, '%d/%m/%Y') as fecha_hora_ingreso, 
                    DATE_FORMAT(h.fecha_hora_salida, '%d/%m/%Y') as fecha_hora_salida, 
                    m.nombre as mascota_nombre, 
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido 
                FROM hoteleria h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN personal p ON h.personal_id = p.personal_id LIMIT $empezar_desde, $tamano_paginas";

        $result = $this->connect()->prepare($sql);
        $result->execute();

        if ($result->rowCount() > 0) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getHospedaje($id)
    {
        $sql = "SELECT h.hospedaje_id, h.fecha_hora_ingreso, h.fecha_hora_salida, m.mascota_id ,m.nombre as mascota_nombre, m.raza, p.personal_id, p.nombre as personal_nombre, p.apellido as personal_apellido FROM hoteleria h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN personal p ON h.personal_id = p.personal_id WHERE h.hospedaje_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function totalHospedajesXBusqueda($filtro)
    {
        $sql = "SELECT 
                    count(*) as total
                FROM hoteleria h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE (m.nombre LIKE :filtro OR m.raza LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro)";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return $data['total'];
        } else {
            return 0;
        }
    }
    public function getHospedajesXBusqueda($filtro, $empezar_desde, $tamano_paginas)
    {
        $sql = "SELECT 
                    h.hospedaje_id, 
                    DATE_FORMAT(h.fecha_hora_ingreso, '%d/%m/%Y') as fecha_hora_ingreso, 
                    DATE_FORMAT(h.fecha_hora_salida, '%d/%m/%Y') as fecha_hora_salida, 
                    m.nombre as mascota_nombre, 
                    m.raza, 
                    p.nombre as personal_nombre, 
                    p.apellido as personal_apellido 
                FROM hoteleria h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE (m.nombre LIKE :filtro OR m.raza LIKE :filtro OR p.nombre LIKE :filtro OR p.apellido LIKE :filtro)
                LIMIT :empezar_desde, :tamano_paginas";
        $result = $this->connect()->prepare($sql);
        $searchTerm = '%' . $filtro . '%';
        $result->bindValue(':filtro', $searchTerm, PDO::PARAM_STR);
        $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
        $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            return $data;
        } else {
            return [];
        }
    }

    public function getHospedajesXMascota($mascota_id)
    {
        $sql = "SELECT h.hospedaje_id, h.fecha_hora_ingreso, h.fecha_hora_salida, p.nombre as personal_nombre, p.apellido as personal_apellido FROM hoteleria h
                INNER JOIN personal p ON h.personal_id = p.personal_id WHERE h.mascota_id = :mascota_id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':mascota_id' => $mascota_id]);
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function altaHospedaje($fecha_hora_ingreso, $fecha_hora_salida, $mascota_id, $personal_id)
    {
        $sql = "INSERT INTO hoteleria (fecha_hora_ingreso, fecha_hora_salida, mascota_id, personal_id) VALUES (:fecha_hora_ingreso, :fecha_hora_salida, :mascota_id, :personal_id)";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha_hora_ingreso' => $fecha_hora_ingreso, ':fecha_hora_salida' => $fecha_hora_salida, ':mascota_id' => $mascota_id, ':personal_id' => $personal_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function bajaHospedaje($id)
    {
        $sql = "DELETE FROM hoteleria WHERE hospedaje_id = :id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':id' => $id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function modificaHospedaje($hospedaje_id, $fecha_hora_ingreso, $fecha_hora_salida, $mascota_id, $personal_id)
    {
        $sql = "UPDATE hoteleria SET fecha_hora_ingreso = :fecha_hora_ingreso, fecha_hora_salida = :fecha_hora_salida, mascota_id = :mascota_id, personal_id = :personal_id WHERE hospedaje_id = :hospedaje_id";
        $sentencia = $this->connect()->prepare($sql);
        $sentencia->execute([':fecha_hora_ingreso' => $fecha_hora_ingreso, ':fecha_hora_salida' => $fecha_hora_salida, ':mascota_id' => $mascota_id, ':personal_id' => $personal_id, ':hospedaje_id' => $hospedaje_id]);
        $sentencia->closeCursor();
        if ($sentencia->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function hospedajeExiste($id)
    {
        $sql = "SELECT * FROM hoteleria WHERE hospedaje_id = :id";
        $result = $this->connect()->prepare($sql);
        $result->execute([':id' => $id]);
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
