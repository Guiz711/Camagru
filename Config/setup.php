<?php
//define('HOME_DIR', '/Users/vbaudron/http/MyWebSite/Camagru/');
//define('HOME_DIR', '/home/guizmo/www/camagru/');

//require_once(HOME_DIR . "Config/database.php");
//require_once(HOME_DIR . "Model/UsersManager.class.php");
// require("./dbRootInfo.php");
require('./config.php');
require_once("$SITE_PATH/Config/database.php");
require_once("$SITE_PATH/Config/init_bdd.php");
require_once("$SITE_PATH/Model/UsersManager.class.php");
require_once("$SITE_PATH/Model/CommentsManager.class.php");
require_once("$SITE_PATH/Model/ImagesManager.class.php");
require_once("$SITE_PATH/Controller/userForm.php");

$pdo = init_bdd($SITE_PATH);

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
 $UserManager = new UsersManager($dbRootInfo);
 $UserManager->insert($var, NULL);

// TEST LOG

// $UserManager->auth("admin", hash('whirlpool', 'admin')); // OK
// $UserManager->auth("admin2", hash('whirlpool', 'admin')); // KO

// TEST Trait Display

$img1 = array("user_id" => "2", "img_description" => "cookie");
$img2 = array("user_id" => "2", "img_description" => "muffin");
$img3 = array("user_id" => "1", "img_description" => "tarte a la fraise");
$ImagesManager = new ImagesManager($dbRootInfo);
// $ImagesManager->insert($img1, NULL);
// $ImagesManager->insert($img2, NULL);
// $ImagesManager->insert($img3, NULL);
$ImagesManager->display_for("2");
$ImagesManager->display_for("9");
$ImagesManager->display_for("1");

// TEST signup

// OK
$sign1 = array('u_login' => 'lea', 'passwd' => hash('whirlpool', 'admin888'), 'mail' => "lea@42.student.fr", 'img_id' => '1');
user_signup($sign1['u_login'], $sign1['passwd'], $sign1['mail'], $dbRootInfo);

// KO -> mail
$sign2 = array('u_login' => 'Gui', 'passwd' => hash('whirlpool', 'admin888'), 'mail' => "vbaudron@42.student.fr", 'img_id' => '1');
user_signup($sign2['u_login'], $sign2['passwd'], $sign2['mail'], $dbRootInfo);

// KO -> login
$sign3 = array('u_login' => 'admin', 'passwd' => hash('whirlpool', 'admin888'), 'mail' => "gui@42.student.fr", 'img_id' => '1');
user_signup($sign3['u_login'], $sign3['passwd'], $sign3['mail'], $dbRootInfo);



?>