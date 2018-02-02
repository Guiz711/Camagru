<?php

require_once("../Config/database.php");

abstract class DbManager
{
	public		$verbose = false;
	protected	$db;
	public		$table;
	protected	$db_name = "db_camagru";

	public function __construct()
	{
		$this->db = $this->connection();
        echo "DbManager --> constructed</br >";

	}

	public function __destruct()
	{
		$this->db = null;
		$this->table = null;
		$this->db_name = null;
		if ($this->verbose)
			echo "DbManager --> destructed</br>";
	}

    public function insert($var, $table)
    {
		$req = " INSERT INTO $table (".implode(", ", array_keys($var))
			. ") VALUES (:".implode(", :", array_keys($var)) . ")";
        echo "</br >" . $req . "</br >";
        try {
            $prep = $this->db->prepare($req);
        }
        catch (PDOException $error) {
            echo "INSERT_fct ERROR of Prepare </br >";
            die('Erreur : ' . $error->getMessage());
        }
        foreach ($var as $key => $value)
            $prep->bindValue(":" . $key, $value);
        try {
            $prep->execute();
        }
        catch (PDOException $error) {
            echo "INSERT_fct ERROR of Execute </br >";
            die('Erreur : ' . $error->getMessage());
        }
    }

    public function update($id, $var, $table)
    {
        $id_key = implode(array_keys($id));
        $req = "UPDATE $table SET ";
        $i = 0;
        foreach ($var as $key => $value)
        {
            if ($i != 0)
                $req .= ", ";
            $req .=  "$key = :$key";
            $i++;
        }
        $req .= " WHERE $id_key=:$id_key";
        echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        foreach ($var as $key => $value)
            $prep->bindValue(":$key", $value);
        $prep->bindValue(":" . $id_key, $id[$id_key]);
        $prep->execute();
    }

    public function delete($id, $table)
    {
        $id_key = implode(array_keys($id));
        $req = "DELETE FROM $table WHERE $id_key=:$id_key";
        echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":" . $id_key, $id[$id_key]);
        $prep->execute();
    }


    public function is_already_in_bdd($var, $and_or, $table) {
        $req = "SELECT * FROM $table WHERE ";
        $i = 0;
        foreach ($var as $key => $value)
        {
            if ($i != 0)
                $req .= " $and_or ";
            $req .=  "$key = :$key";
            $i++;
        }
        echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        foreach ($var as $key => $value)
            $prep->bindValue(":$key", $value);
        $prep->execute();
        $result = $prep->fetchAll();
        if (array_key_exists("0", $result))
            return (TRUE);
        else
            return (FALSE);
    }

    // public function read();
    // public function update();
    // abstract public function delete();
    
    protected function connection()
    {
        require("../Config/database.php");

        try {
            $pdo = new PDO($dbRootInfo["DB_DSN"], $dbRootInfo["DB_USER"], $dbRootInfo["DB_PASS"]);
            return ($pdo);
        }
        catch (Exception $error) {
            die('Erreur : ' . $error->getMessage());
        }
    }
}
?>