<?php

abstract class DbManager
{
	public		$verbose = false;
	protected	$db;
    public		$table;
    public      $id_name;
	protected	$db_name = "db_camagru";

	public function __construct($table, $id_name)
	{
        $this->table = $this->db_name . $table;
        $this->id_name = $id_name;
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

    public function insert($var)
    {
		$req = " INSERT INTO $this->table (".implode(", ", array_keys($var))
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

    public function update($id, $var)
    {
        $id_key = implode(array_keys($id));
        $req = "UPDATE $this->table SET ";
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

    public function delete($id)
    {
        $id_key = implode(array_keys($id));
        $req = "DELETE FROM $this->table WHERE $id_key=:$id_key";
        echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":" . $id_key, $id[$id_key]);
        $prep->execute();
    }


    public function is_already_in_bdd($var, $and_or) {
        $req = "SELECT * FROM $this->table WHERE ";
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

    public function select_all_id() {
        $req = "SELECT $this->id_name FROM $this->table";
        $prep = $this->db->prepare($req);
        $prep->execute();
        $result = $prep->fetchAll();
        $tab = array();
        foreach ($result as $value1) {
            foreach ($value1 as $key => $value) {
                if ($key === $this->id_table) {
                    $tab[] = $value;
                }
            }
        }
        echo "</br >All $this->id_name from $this->table : </br >";
        print_r($tab);
        echo "</br >";
        return ($tab);
    }

    
    public function connection()
    {
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
            return ($pdo);
        }
        catch (Exception $error) {
            die('Erreur : ' . $error->getMessage());
        }
    }
}
?>