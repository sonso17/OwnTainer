<?php

class BdD
{
	public $db_host;
	public $db_user;
	public $db_password;
	public $db_name;

	public function __construct()
	{
		$this->db_host = "localhost";
		$this->db_user = "daw";
		$this->db_password = "";
		$this->db_name = "owntainer";
	}

	public function connect()
	{
		$db_connection = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);

		if (!$db_connection) {
			return "error al connectar";
		} else {
			return $db_connection;
		}
	}
}