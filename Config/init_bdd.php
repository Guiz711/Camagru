<?php

//define('HOME_DIR', '/Users/vbaudron/http/MyWebSite/Camagru/');
//define('HOME_DIR', '/home/guizmo/www/camagru/');
//require_once(HOME_DIR . 'Config/dbRootInfo.php');

function init_bdd() 
{
	require("./database.php");
    $db = "db_camagru";
    echo "Connection</br ></br >";

    try {
        $pdo = new PDO("mysql:host=localhost;charset=utf8", $DB_USER, $DB_PASSWORD);
        // $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }

    $req = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET 'utf8'";
    $pdo->prepare($req)->execute();
    echo "</br >Creation Database : $db </br >";
    // return ($pdo);

    try {
        $connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        // $connection = new PDO("mysql:host=localhost;dbname=$db;charset=utf8", $DB_USER, $DB_PASSWORD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }  
    return ($connection);
}

?>