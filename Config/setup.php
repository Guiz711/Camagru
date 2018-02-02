<?php
require_once("./init_bdd.php");

$pdo = init_bdd();
$db = "db_camagru";

echo "</br >Creation Tables : $table</br >";

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

$pdo->query($req);
echo "Creation Table : $table</br >";

$table = "images";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    img_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_description VARCHAR(256),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->query($req);
echo "Creation Table : $table</br >";

$table = "likes";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    like_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL
)";
$pdo->query($req);
echo "Creation Table : $table</br >";

$table = "comments";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    comment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL,
    text_comment VARCHAR(256) NOT NULL,
    date_comment TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->query($req);
echo "Creation Table : $table</br >";

// INSERTION USERS
echo "</br >Insertion Datas :</br >";

$table = "$db.users";
$login = "admin";
$passwd = password_hash('admin', PASSWORD_DEFAULT);
$mail = "vbaudron@student.42.fr";
$img = "2";
$req = "INSERT INTO $table (u_login, passwd, mail, img_id) VALUES ('$login', '$passwd', '$mail', '$img')";
echo "Insertion User : $login</br >";

$pdo->query($req);


$table = "$db.users";
$login = "lea";
$passwd = password_hash('lea', PASSWORD_DEFAULT);
$mail = "lesanche@student.42.fr";
$img = "1";
$req = "INSERT INTO $table (u_login, passwd, mail) VALUES ('$login', '$passwd', '$mail')";
echo "Insertion User : $login</br >";

$pdo->query($req);


// INSERTION IMAGE 1

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une jolie image";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "Insertion Image : 1 </br ></br >";

$pdo->query($req);
?>