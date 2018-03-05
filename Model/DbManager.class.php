<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}



abstract class DbManager
{
	public		$verbose = false;
	protected	$db;
    public		$table;
    
	public function __construct($table, $id_name)
	{
        $db_name = $DB_DSN;
        $db_name = strstr($db_name, 'dbname=');
        $db_name = strstr($db_name, ';', true);
        $db_name = explode("=", $db_name);
        $db_name = $db_name[1];
        
        $this->table = $this->db_name . $table;
        $this->id_name = $id_name;
        $this->db = $this->connection();
        if ($this->verbose)
            echo "DbManager --> constructed</br >";
	}

	public function __destruct()
	{
        $db_name = $DB_DSN;
        $db_name = strstr($db_name, 'dbname=');
        $db_name = strstr($db_name, ';', true);
        $db_name = explode("=", $db_name);
        $db_name = $db_name[1];
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
        if ($this->verbose)
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
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        foreach ($var as $key => $value)
            $prep->bindValue(":$key", $value);
        $prep->bindValue(":" . $id_key, $id[$id_key]);
        $prep->execute();
    }

    public function delete($where)
    {
        $id_key = implode(array_keys($where));
        $req = "DELETE FROM $this->table WHERE $id_key=:$id_key";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":" . $id_key, $where[$id_key]);
        $prep->execute();
    }

    public function is_already_in_bdd($var, $and_or, $order) {
        $req = "SELECT * FROM $this->table WHERE ";
        $i = 0;
        foreach ($var as $key => $value)
        {
            if ($i != 0)
                $req .= " $and_or ";
            $req .=  "$key = :$key";
            $i++;
        }
        if ($order) {
            $req .= " ORDER BY $order";
        }
        if ($this->verbose)
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

   
    public function select_all($where, $and_or, $order) {
        $req = "SELECT * FROM $this->table";
        if ($where) {
            $req .= " WHERE ";
            $i = 0;
            foreach ($where as $key => $value)
            {
            if ($i != 0)
                $req .= " $and_or ";
            $req .=  "$key = :$key";
            $i++;
            }
        }
        if ($order) {
            $req .= " ORDER BY $order";
        }
        if ($this->verbose)
            echo $req;
        $prep = $this->db->prepare($req);
        if ($where) {
            foreach ($where as $key => $value)
                $prep->bindValue(":$key", $value);
        }
        $prep->execute();
        $result = $prep->fetchAll();
        $tab = array();
        if ($this->verbose) {
            echo "</br >All * from $this->table : </br >";
            DEBUG_print($result);
            echo "</br >";
        }
        return ($result);
    }

    public function select_all_id($where, $and_or, $order) {
        $req = "SELECT $this->id_name FROM $this->table";
        if ($where) {
            $req .= " WHERE ";
            $i = 0;
            foreach ($where as $key => $value)
            {
            if ($i != 0)
                $req .= " $and_or ";
            $req .=  "$key = :$key";
            $i++;
            }
        }
        if ($order) {
            $req .= " ORDER BY $order";
        }
        if ($this->verbose)
            echo $req;
        $prep = $this->db->prepare($req);
        if ($where) {
            foreach ($where as $key => $value)
                $prep->bindValue(":$key", $value);
        }
        $prep->execute();
        $result = $prep->fetchAll();
        $tab = array();
        foreach ($result as $value1) {
            $tab[] = $value1[$this->id_name];
        }
        if ($this->verbose) {
            echo "</br >All $this->id_name from $this->table : </br >";
            print_r($tab);
            echo "</br >";
        }
        return ($tab);
    }

    public function count_id($is_where, $id_name, $id_tocheck) {
        $req = "SELECT COUNT(*) AS 'nb' FROM $this->table";
        if ($is_where)
            $req .= " WHERE $id_name = :$id_name";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":$id_name", $id_tocheck);
        $prep->execute();
        $result = $prep->fetchAll();
        if ($this->verbose) {
            echo "</br >Count of $id_name=$id_tocheck from $this->table : </br >";
            print_r($result);
        }
        return ($result['0']['nb']);
    }
    
    public function connection()
    {
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return ($pdo);
        }
        catch (PDOException $error) {
            die('Erreur : ' . $error->getMessage());
        }
    }
}
?>