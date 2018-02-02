<?php
require_once("$SITE_PATH/Model/DbManager.class.php");

class UsersManager extends DbManager {
    function __construct($dbRootInfo) {
        parent::__construct($dbRootInfo);
        $this->table = $this->db_name . ".users";
        echo "UsersManager --> constructed</br >";
    }

    public function insert($var, $table) {
        parent::insert($var, $this->table);
    }

    public function update($id, $var, $table) {
        parent::update($id, $var, $this->table);
    }

    public function delete($id, $table) {
        parent::delete($id, $this->table);
    }

    public function is_already_in_bdd($var, $and_or, $table) {
        return(parent::is_already_in_bdd($var, $and_or, $this->table));
    }

    public function auth($login, $passwd) {
        $req = "SELECT * FROM $this->table WHERE u_login=:u_login AND passwd=:passwd";
        // echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":u_login", $login);
        $prep->bindValue(":passwd", $passwd);
        $prep->execute();
        $result = $prep->fetchAll();
        if (array_key_exists('0', $result))
        {
            echo "</br >HELLO $login We found YOU ;) </br >";
            return (TRUE);
        }
        else {
            echo "</br >Hey $login Are you real ?? </br >";
            return (FALSE);
        }
    }


}

?>