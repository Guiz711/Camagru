<?php
include_once(HOME_DIR . "config/database.php");

abstract class DbManager
{
    public $verbose = false;
    protected $db;
    public $table;
    protected $db_name = "db_camagru";

    function __construct() {
        $this->db = $this->connection();
        echo "DbManager --> constructed</br >";
    }

    public function insert($var, $table)
    {
        $req = " INSERT INTO $table (".implode(", ", array_keys($var)) . ") VALUES (:".implode(", :", array_keys($var)) . ")";
        echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        foreach ($var as $key => $value)
            $prep->bindValue(":" . $key, $value);
        $prep->execute();
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

    // public function read();
    // public function update();
    // abstract public function delete();
    
    protected function    connection() // a proteger
    {
        $var = setup_DbVar();
        try {
            $db = new PDO ($var["DB_DSN"], $var["DB_USER"], $var["DB_PASS"]);
            return ($db);
        } catch (Exception $err) {
            if ($verbose) //pas sur de gerer l'affichage de cette maniere...
                throw new Exception("DataBase connection error :" . $err);
        }
    }
}
?>