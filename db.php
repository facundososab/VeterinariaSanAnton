<?php

require_once "config/server.php";

class Database
{
	private $server = DB_SERVER;
	private $db = DB_NAME;
	private $user = DB_USER;
	private $pass = DB_PASS;

	function __construct()
	{
		$this->server = DB_SERVER;
		$this->db = DB_NAME;
		$this->user = DB_USER;
		$this->pass = DB_PASS;
	}


	/*----------  Funcion conectar a BD  ----------*/
	function connect()
	{
		$conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
		$conexion->exec("SET CHARACTER SET utf8");
		return $conexion;
	}
}
