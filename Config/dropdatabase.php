<?php
session_start();
session_destroy();
require_once("./init_bdd.php");

$pdo = init_bdd();
$db = "db_camagru";

$pdo->query("DROP DATABASE $db");
echo "DATABASE : $db KILLED</br >";
?>