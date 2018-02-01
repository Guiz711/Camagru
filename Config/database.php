<?php

//define('HOME_DIR', '/Users/vbaudron/http/MyWebSite/Camagru/');
//define('HOME_DIR', '/home/guizmo/www/camagru/');
//require_once(HOME_DIR . 'Config/dbRootInfo.php');

function init_bdd() 
{
	require("./dbRootInfo.php");
    
    $db = "db_camagru";

    try {
        $pdo = new PDO($dbRootInfo["DB_DSN"], $dbRootInfo["DB_USER"], $dbRootInfo["DB_PASS"]);
    }
    catch (Exception $error) {
        die('Erreur : ' . $error->getMessage());
    }

    $req = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET 'utf8'";
    $pdo->prepare($req)->execute();

    try {
        $connection = new PDO("mysql:host=localhost;dbname=$db;charset=utf8", $dbRootInfo['DB_USER'], $dbRootInfo['DB_PASS']);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }  
    return ($connection);
}

?>