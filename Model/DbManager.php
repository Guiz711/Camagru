<?php

abstract class DbManager
{
	public $verbose = false;

	abstract public function create();
	abstract public function read();
	abstract public function update();
	abstract public function delete();

	protected function	connection($dsn, $user, $pwd)
	{
		try {
			$db = new PDO($dsn, $user, $pwd);
			return $db;
		} catch (PDOException $err) {
			throw new Exception("DataBase connection error :" . $err->getMessage());
		}
	}
}

?>
