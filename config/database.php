<?php

function setup_DbVar()
{
    $var = array(DB_USER => "root", DB_PASS => "vivelescookies", DB_DSN => "mysql:host=localhost;charset=utf8");
    return ($var);
}

function init_bdd() 
{
    
    $var = setup_DbVar();

    $db = "db_camagru";

    try {
        $pdo = new PDO($var["DB_DSN"], $var["DB_USER"], $var["DB_PASS"]);
    }
    catch (Exception $error) {
        die('Erreur : ' . $error->getMessage());
    }

    $req = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET 'utf8'";
    $pdo->prepare($req)->execute();

    try {
        $connection = new PDO("mysql:host=localhost;dbname=$db;charset=utf8", $var['DB_USER'], $var['DB_PASS']);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }  
    return ($connection);
}
?>