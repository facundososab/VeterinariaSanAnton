<?php
if (file_exists("../../db.php")) {
  require_once "../../db.php";
} else {
  require_once "../db.php";
}

class Cliente extends Database
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getClienteInfo($cliente_id)
  {
    $sql = "SELECT * FROM clientes WHERE cliente_id = :cliente_id";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function updateCliente($cliente_id, $nombre, $apellido, $email)
  {
    $sql = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, email = :email WHERE cliente_id = :cliente_id";
    $sentencia = $this->connect()->prepare($sql);
    $sentencia->execute([':nombre' => $nombre, ':apellido' => $apellido, ':email' => $email, ':cliente_id' => $cliente_id]);
    $sentencia->closeCursor();
    if ($sentencia->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function updateClientePassword($cliente_id, $clave)
  {
    $sql = "UPDATE clientes SET clave = :clave WHERE cliente_id = :cliente_id";
    $sentencia = $this->connect()->prepare($sql);
    $sentencia->execute([':clave' => $clave, ':cliente_id' => $cliente_id]);
    $sentencia->closeCursor();
    if ($sentencia->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getAtencionesHoy($cliente_id)
  {
    $sql = "SELECT atenciones.fecha_hora, mascotas.nombre as mascota_nombre, clientes.nombre as cliente_nombre, clientes.apellido as cliente_apellido, servicios.nombre as servicio_nombre, personal.nombre as personal_nombre, personal.apellido as personal_apellido
              FROM atenciones
              JOIN mascotas ON atenciones.mascota_id = mascotas.mascota_id
              JOIN clientes ON mascotas.cliente_id = clientes.cliente_id
              JOIN servicios ON atenciones.servicio_id = servicios.servicio_id
              JOIN personal ON atenciones.personal_id = personal.personal_id
              WHERE clientes.cliente_id = :cliente_id AND DATE(atenciones.fecha_hora) = CURDATE() AND atenciones.estado = 'PENDIENTE'";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    if ($data) {
      return $data;
    } else {
      return [];
    }
  }

  public function getProximasAtenciones($cliente_id)
  {
    $sql = "SELECT atenciones.fecha_hora, mascotas.nombre as mascota_nombre, clientes.nombre as cliente_nombre, clientes.apellido as cliente_apellido, servicios.nombre as servicio_nombre, personal.nombre as personal_nombre, personal.apellido as personal_apellido
              FROM atenciones
              JOIN mascotas ON atenciones.mascota_id = mascotas.mascota_id
              JOIN clientes ON mascotas.cliente_id = clientes.cliente_id
              JOIN servicios ON atenciones.servicio_id = servicios.servicio_id
              JOIN personal ON atenciones.personal_id = personal.personal_id
              WHERE clientes.cliente_id = :cliente_id AND DATE(atenciones.fecha_hora)   > CURDATE() AND atenciones.estado = 'PENDIENTE'";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    if ($data) {
      return $data;
    } else {
      return [];
    }
  }

  public function getMascota($id)
  {
    $sql = "SELECT m.mascota_id, m.nombre, m.raza, m.color, DATE_FORMAT(m.fecha_nac, '%d/%m/%Y') as fecha_nac, m.fecha_muerte, c.nombre as cliente_nombre, c.apellido as cliente_apellido, c.email as cliente_email FROM mascotas m
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id WHERE m.mascota_id = :id";
    $result = $this->connect()->prepare($sql);
    $result->execute([':id' => $id]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function totalMascotas($cliente_id)
  {
    $sql = "SELECT COUNT(*) as total_mascotas FROM mascotas WHERE cliente_id = :cliente_id";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    return $data['total_mascotas'];
  }

  public function getAllMascotas($cliente_id, $empezar_desde, $tamano_paginas)
  {
    $sql = "SELECT * FROM mascotas WHERE cliente_id = :cliente_id LIMIT $empezar_desde, $tamano_paginas";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }

  public function totalMascotasXBusqueda($cliente_id, $filtro)
  {
    $sql = "SELECT COUNT(*) as total_mascotas FROM mascotas WHERE cliente_id = :cliente_id AND nombre LIKE :filtro";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id, 'filtro' => "%$filtro%"]);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    return $data['total_mascotas'];
  }

  public function getMascotasXBusqueda($cliente_id, $filtro, $empezar_desde, $tamano_paginas)
  {
    $sql = "SELECT * FROM mascotas WHERE cliente_id = :cliente_id AND nombre LIKE :filtro LIMIT $empezar_desde, $tamano_paginas";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id, 'filtro' => "%$filtro%"]);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }


  public function getAtencionesXMascota($mascota_id)
  {
    $sql = "SELECT a.atencion_id, a.fecha_hora, a.titulo, a.descripcion, p.nombre as personal_nombre, p.apellido as personal_apellido, s.nombre as servicio_nombre 
            FROM atenciones a
                INNER JOIN personal p ON a.personal_id = p.personal_id
                INNER JOIN servicios s ON a.servicio_id = s.servicio_id WHERE a.mascota_id = :mascota_id
                AND a.estado = 'FINALIZADA'";
    $result = $this->connect()->prepare($sql);
    $result->execute([':mascota_id' => $mascota_id]);
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  public function totalAtenciones($cliente_id)
  {
    $sql = "SELECT * FROM atenciones a
                INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                WHERE c.cliente_id = :cliente_id";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $row = $result->rowCount();
    return $row;
  }

  public function getAllAtenciones($cliente_id, $empezar_desde, $tamano_paginas)
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
                WHERE c.cliente_id = :cliente_id
                ORDER BY a.fecha_hora DESC
                LIMIT :empezar_desde, :tamano_paginas";
    $result = $this->connect()->prepare($sql);
    $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
    $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $result->execute();
    if ($result->rowCount() > 0) {
      return $result;
    } else {
      return false;
    }
  }

  public function totalAtencionesXBusqueda($cliente_id, $filtro)
  {
    $sql = "SELECT count(*) as total
            FROM atenciones a
            INNER JOIN mascotas m ON a.mascota_id = m.mascota_id
            INNER JOIN clientes c ON m.cliente_id = c.cliente_id
            INNER JOIN personal p ON a.personal_id = p.personal_id
            INNER JOIN servicios s ON a.servicio_id = s.servicio_id
            WHERE (a.titulo LIKE :f1 OR a.descripcion LIKE :f2 OR m.nombre LIKE :f3 OR m.raza LIKE :f4 
                OR p.nombre LIKE :f5 OR p.apellido LIKE :f6 OR c.nombre LIKE :f7 OR c.apellido LIKE :f8 
                OR s.nombre LIKE :f9)
            AND c.cliente_id = :cliente_id
            ORDER BY a.fecha_hora DESC";

    $result = $this->connect()->prepare($sql);

    // Definir el término de búsqueda para cada filtro
    $searchTerm = '%' . $filtro . '%';

    // Vincular los parámetros con los filtros respectivos
    $result->bindValue(':f1', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f2', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f3', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f4', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f5', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f6', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f7', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f8', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f9', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $result->execute();

    // Obtener el resultado
    $data = $result->fetch(PDO::FETCH_ASSOC);

    // Devolver el total de atenciones encontradas
    return $data ? (int) $data['total'] : 0;
  }


  public function getAtencionesXBusqueda($cliente_id, $filtro, $empezar_desde, $tamano_paginas)
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
            WHERE (a.titulo LIKE :f1 OR a.descripcion LIKE :f2 OR m.nombre LIKE :f3 OR m.raza LIKE :f4 
                OR p.nombre LIKE :f5 OR p.apellido LIKE :f6 OR c.nombre LIKE :f7 OR c.apellido LIKE :f8 
                OR s.nombre LIKE :f9)
            AND c.cliente_id = :cliente_id
            ORDER BY a.fecha_hora DESC
            LIMIT :empezar_desde, :tamano_paginas";

    $result = $this->connect()->prepare($sql);

    // Definir el término de búsqueda para cada filtro
    $searchTerm = '%' . $filtro . '%';

    // Vincular los parámetros con los filtros respectivos
    $result->bindValue(':f1', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f2', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f3', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f4', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f5', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f6', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f7', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f8', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f9', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
    $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);

    // Ejecutar la consulta
    $result->execute();

    // Verificar si hay resultados y devolverlos
    if ($result->rowCount() > 0) {
      return $result->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return false;
    }
  }


  public function cancelaAtencion($atencion_id)
  {
    $sql = "UPDATE atenciones SET estado = 'CANCELADA' WHERE atencion_id = :atencion_id";
    $sentencia = $this->connect()->prepare($sql);
    $sentencia->execute([':atencion_id' => $atencion_id]);
    $sentencia->closeCursor();
    if ($sentencia->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function totalHospedajes($cliente_id)
  {
    $sql = "SELECT * FROM hoteleria h
                INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                WHERE c.cliente_id = :cliente_id";
    $result = $this->connect()->prepare($sql);
    $result->execute(['cliente_id' => $cliente_id]);
    $row = $result->rowCount();
    return $row;
  }


  public function getAllHospedajes($cliente_id, $empezar_desde, $tamano_paginas)
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
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE c.cliente_id = :cliente_id
                LIMIT :empezar_desde, :tamano_paginas";
    $result = $this->connect()->prepare($sql);
    $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
    $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    if ($data) {
      return $data;
    } else {
      return [];
    }
  }

  public function totalHospedajesXBusqueda($cliente_id, $filtro)
  {
    $sql = "SELECT 
                count(*) as total
            FROM hoteleria h
            INNER JOIN mascotas m ON h.mascota_id = m.mascota_id
            INNER JOIN clientes c ON m.cliente_id = c.cliente_id
            INNER JOIN personal p ON h.personal_id = p.personal_id
            WHERE (m.nombre LIKE :f1 OR m.raza LIKE :f2 OR p.nombre LIKE :f3 OR p.apellido LIKE :f4)
            AND c.cliente_id = :cliente_id";

    $result = $this->connect()->prepare($sql);

    // Definir el término de búsqueda para cada filtro
    $searchTerm = '%' . $filtro . '%';

    // Vincular los parámetros con los filtros respectivos
    $result->bindValue(':f1', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f2', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f3', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f4', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $result->execute();

    // Obtener el resultado
    $data = $result->fetch(PDO::FETCH_ASSOC);

    // Devolver el total o 0 si no se encontró
    return $data ? (int) $data['total'] : 0;
  }

  public function getHospedajesXBusqueda($cliente_id, $filtro, $empezar_desde, $tamano_paginas)
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
                INNER JOIN clientes c ON m.cliente_id = c.cliente_id
                INNER JOIN personal p ON h.personal_id = p.personal_id
                WHERE (m.nombre LIKE :f1 OR m.raza LIKE :f2 OR p.nombre LIKE :f3 OR p.apellido LIKE :f4)
                AND c.cliente_id = :cliente_id
                LIMIT :empezar_desde, :tamano_paginas";

    $result = $this->connect()->prepare($sql);
    $searchTerm = '%' . $filtro . '%';
    $result->bindValue(':f1', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f2', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f3', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':f4', $searchTerm, PDO::PARAM_STR);
    $result->bindValue(':empezar_desde', $empezar_desde, PDO::PARAM_INT);
    $result->bindValue(':tamano_paginas', $tamano_paginas, PDO::PARAM_INT);
    $result->bindValue(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data ?: [];
  }
}
