<?php
// require_once("../Model/DbManager.class.php");

class UsersManager extends DbManager {
    function __construct() {
        parent::__construct(".users", "user_id");
        if ($this->verbose)
            echo "UsersManager --> constructed</br >";
    }
    
    // public function auth($login, $passwd) {
    //     $req = "SELECT * FROM $this->table WHERE u_login=:u_login AND passwd=:passwd";
    //     // echo "</br >" . $req . "</br >";
    //     $prep = $this->db->prepare($req);
    //     $prep->bindValue(":u_login", $login);
    //     $prep->bindValue(":passwd", $passwd);
    //     $prep->execute();
    //     $result = $prep->fetchAll();
    //     if (array_key_exists('0', $result))
    //     {
    //         echo "</br >HELLO $login We found YOU ;) </br >";
    //         return (TRUE);
    //     }
    //     else {
    //         echo "</br >Hey $login Are you real ?? </br >";
    //         return (FALSE);
    //     }
    // }

    public function auth($login, $passwd) {
        $req = "SELECT user_id, passwd, mail, cle, actif FROM $this->table WHERE u_login=:u_login";
        // echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":u_login", $login);
        $prep->execute();
        $result = $prep->fetchAll();
        return ($result);
    }

    public function confirm_inscription($login, $cle)
    {
        $req = "UPDATE $this->table SET actif=1 WHERE cle=:cle AND u_login=:login";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":cle", $cle);
        $prep->bindValue(":login", $login);
        $prep->execute();
    }

}

?>