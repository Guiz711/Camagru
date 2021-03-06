<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

class UsersManager extends DbManager {
    function __construct() {
        parent::__construct(".users", "user_id");
        if ($this->verbose)
            echo "UsersManager --> constructed</br >";
    }
    
    public function auth($login) {
        $req = "SELECT user_id, passwd, mail, cle, actif, tmp FROM $this->table WHERE u_login=:u_login";
		if ($this->verbose)
			echo "</br >" . $req . "</br >";
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

	public function change_passwd($passwd, $login)
    {
        $req = "UPDATE $this->table SET passwd=:passwd WHERE u_login=:login";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
        $prep = $this->db->prepare($req);
        $prep->bindValue(":passwd", $passwd);
        $prep->bindValue(":login", $login);
        $prep->execute();
	}
	
	public function forgot_passwd($login, $forgot_passwd, $mail)
    {
        $req = "UPDATE $this->table SET forgot_passwd=:forgot_passwd WHERE u_login=:login OR mail=:mail";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
		$prep = $this->db->prepare($req);
		$prep->bindValue(":login", $login);
		$prep->bindValue(":mail", $mail);
		$prep->bindValue(":forgot_passwd", $forgot_passwd);
		$prep->execute();
		return($forgot_passwd);
    }

    public function find_login($id) {
        $req = "SELECT u_login FROM $this->table WHERE user_id=:user_id";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
		$prep = $this->db->prepare($req);
		$prep->bindValue(":user_id", $id);
        $prep->execute();
        $result = $prep->fetchAll();
        return ($result);
    }

    public function user_modify($id, $tomodify, $val) {
        $req = "UPDATE $this->table SET $tomodify=:val WHERE user_id=:id";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
		$prep = $this->db->prepare($req);
		$prep->bindValue(":val", $val);
		$prep->bindValue(":id", $id);
		$prep->execute();
    }

    public function find_login_mail_notifications($id) {
        $req = "SELECT u_login, mail, notifications FROM $this->table WHERE user_id=:user_id";
        if ($this->verbose)
            echo "</br >" . $req . "</br >";
		$prep = $this->db->prepare($req);
		$prep->bindValue(":user_id", $id);
        $prep->execute();
        $result = $prep->fetchAll();
        return ($result);
    }
}

?>