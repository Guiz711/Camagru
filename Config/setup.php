<?php
require_once("./init_bdd.php");

$pdo = init_bdd();

$table = "users";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    u_login VARCHAR(42) NOT NULL,
    passwd VARCHAR(256) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    img_id INT DEFAULT 1,
    date_subcription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->prepare($req)->execute();

$table = "images";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    img_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_description VARCHAR(256),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->prepare($req)->execute();

$table = "likes";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    like_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL
)";
$pdo->prepare($req)->execute();

$table = "comments";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    comment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL,
    text_comment VARCHAR(256) NOT NULL,
    date_comment TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->prepare($req)->execute();

// $result = $pdo->prepare($req)->execute();


// INSERTION USERS

$table = "users";
$login = "admin";
$passwd = password_hash('admin', PASSWORD_DEFAULT);
$mail = "vbaudron@student.42.fr";
$req = "INSERT INTO $table (u_login, passwd, mail) VALUES ($login, $passwd, $mail)";
echo "$req </br ></br >";
$pdo->prepare($req)->execute();

$table = "users";
$login = "lea";
$passwd = password_hash('lea', PASSWORD_DEFAULT);
$mail = "lesanche@student.42.fr";
$req = "INSERT INTO $table (u_login, passwd, mail) VALUES ($login, $passwd, $mail)";
echo "$req </br ></br >";
$pdo->prepare($req)->execute();

// INSERTION IMAGE 1

$table = "images";
$user_id = "1";
$img_description = "Ceci est une jolie image";
$req = "INSERT INTO $table (user_id, img_description) VALUES ($user_id, $img_description)";
echo "$req </br ></br >";
$pdo->prepare($req)->execute();
?>