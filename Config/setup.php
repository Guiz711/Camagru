<?php
//define('HOME_DIR', '/Users/vbaudron/http/MyWebSite/Camagru/');
//define('HOME_DIR', '/home/guizmo/www/camagru/');

//require_once(HOME_DIR . "Config/database.php");
//require_once(HOME_DIR . "Model/UsersManager.class.php");
require("./dbRootInfo.php");
require_once("./database.php");
require_once("../Model/UsersManager.class.php");

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
    likes_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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

$result = $pdo->prepare($req)->execute();


// INSERER L'ADMIN

$var = array('u_login' => 'admin', 'passwd' => hash('whirlpool', 'admin'), 'mail' => "vbaudron@42.student.fr", 'img_id' => '2');
$UserManager = new UsersManager();
$UserManager->insert($var, NULL);

// TEST LOG

$UserManager->auth("admin", hash('whirlpool', 'admin')); // OK
$UserManager->auth("admin2", hash('whirlpool', 'admin')); // KO
$UserManager->auth("admin", hash('whirlpool', 'admin2')); // KO

?>