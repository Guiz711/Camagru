<?php

class User extends UsersManager {
    public $u_login;
    public $passwd;
    
    public function new($var) {
        if (array_key_exists("u_login") && array_key_exists("passwd"))
        {
            $this->u_login = $var["u_login"];
            parent::insert($var)
        }
    }

}

?>