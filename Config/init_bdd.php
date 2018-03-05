<?php
function init_bdd() 
{
	require("./database.php");
    // $db = "db_camagru";
    $db = $DB_DSN;
    $db = explode(";", $db);
    $db = explode("=", $db[1]);
    $db = $db[1];
    // echo $db;

    echo "Connexion à la base de données</br></br >";
    try {
        $pdo = new PDO("mysql:host=localhost;charset=utf8", $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }
    $req = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET 'utf8'";
    $pdo->prepare($req)->execute();
    echo "</br >Création de la database : $db </br >";
    try {
        $connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $error) {
        die('Erreur : ' . $error->getMessage());
    }  
    return ($connection);
}
?>