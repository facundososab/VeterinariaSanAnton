<?php

require_once "config/server.php";

class Database
{
	private $server;
	private $db;
	private $user;
	private $pass;
	private $port;

	function __construct()
	{
		$this->server = DB_SERVER;
		$this->db = DB_NAME;
		$this->user = DB_USER;
		$this->pass = DB_PASS;
		$this->port = DB_PORT;
	}

	/*----------  Función para conectar a la BD  ----------*/
	function connect()
	{
		try {
			$dsn = "mysql:host=" . $this->server . ";port=" . $this->port . ";dbname=" . $this->db . ";charset=utf8";
			$conexion = new PDO($dsn, $this->user, $this->pass, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devolver resultados como array asociativo
				PDO::ATTR_EMULATE_PREPARES => false // Mejor seguridad en consultas preparadas
			]);

			return $conexion;
		} catch (PDOException $e) {
			die("❌ Error de conexión: " . $e->getMessage());
		}
	}
}
