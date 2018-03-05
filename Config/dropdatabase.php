<?php
session_start();
session_destroy();
require_once("./init_bdd.php");
require_once("./database.php");

$pdo = init_bdd();
// $db = "db_camagru";
$db = $DB_DSN;
$db = explode(";", $db);
$db = explode("=", $db[1]);
$db = $db[1];

$pdo->query("DROP DATABASE $db");
echo "La base de données $db détruite </br >";
?>