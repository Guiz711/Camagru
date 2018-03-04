<?php
require_once("./init_bdd.php");

$pdo = init_bdd();
$db = "db_camagru";

echo "</br >Creation Tables</br >";

$table = "users";
$forgot_passwd = md5(microtime(TRUE)*100000);
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    u_login VARCHAR(42) NOT NULL,
    passwd VARCHAR(256) NOT NULL,
    mail VARCHAR(50) NOT NULL,
    img_id INT DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cle VARCHAR(32),
    actif INT DEFAULT 0,
	forgot_passwd VARCHAR(32),
    notifications INT DEFAULT 1,
    tmp VARCHAR(50) 
)";

$pdo->query($req);
echo "--> Creation Table : $table</br >";

$table = "images";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    img_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_description VARCHAR(256),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->query($req);
echo "--> Creation Table : $table</br >";

$table = "likes";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    like_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL
)";
$pdo->query($req);
echo "--> Creation Table : $table</br >";

$table = "comments";
$req = "CREATE TABLE IF NOT EXISTS $table 
(
    comment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    img_id INT NOT NULL,
    text_comment VARCHAR(256) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
try {
    $pdo->query($req);
    echo "--> Creation Table : $table</br >";
}
catch (Exception $error) {
    echo "SOMETHING WRONG with la Creation de la Table : $table</br >";
    die('Erreur : ' . $error->getMessage());
}


// INSERTION USERS
echo "</br >Insertion Datas</br >";

$table = "$db.users";
$login = "admin";
$passwd = password_hash('admin', PASSWORD_DEFAULT);
$mail = "vbaudron@student.42.fr";
$img = "2";
$forgot_passwd = md5(microtime(TRUE)*100000);
$req = "INSERT INTO $table (u_login, passwd, mail, img_id, actif, forgot_passwd) VALUES ('$login', '$passwd', '$mail', '$img', '1', '$forgot_passwd')";
echo "--> Insertion USER : $login</br >";

$pdo->query($req);


$table = "$db.users";
$login = "lea";
$passwd = password_hash('lea', PASSWORD_DEFAULT);
$mail = "lesanche@student.42.fr";
$img = "1";
$forgot_passwd = md5(microtime(TRUE)*100000);
$req = "INSERT INTO $table (u_login, passwd, mail, img_id, actif, forgot_passwd) VALUES ('$login', '$passwd', '$mail', '$img', '1', '$forgot_passwd')";
echo "--> Insertion USER : $login</br >";

$pdo->query($req);


// INSERTION IMAGE 1

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une jolie image";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 1 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "2";
$img_description = "Ceci est une magnifiqueimage";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 2 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une image geniale";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 3 </br >";

$pdo->query($req);


$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une image de dingue";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 4 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une image inspirante";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 5 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une image ouf";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 6 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "1";
$img_description = "Ceci est une image qui donne faim";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 7 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "2";
$img_description = "A table";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 8 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "1";
$img_description = "Gourmandise";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 9 </br >";

$pdo->query($req);

$table = "$db.images";
$user_id = "2";
$img_description = "A table";
$req = "INSERT INTO $table (user_id, img_description) VALUES ('$user_id', '$img_description')";
echo "--> Insertion IMAGE : 10 </br >";

$pdo->query($req);


// INSERTION LIKE

$table = "$db.likes";
$user_id = "1";
$img_id = "1";
$req = "INSERT INTO $table (user_id, img_id) VALUES ('$user_id', '$img_id')";
echo "--> Insertion User $user_id LIKES image $img_id </br >";

$pdo->query($req);

// INSERTION COMMENT

$table = "$db.comments";
$user_id = "1";
$img_id = "2";
$text_comment = "This is an admin comment";
$req = "INSERT INTO $table (user_id, img_id, text_comment) VALUES ('$user_id', '$img_id', '$text_comment')";
echo "--> Insertion COMMENT '$text_comment' from User $user_id on image $img_id </br ></br >";

$pdo->query($req);

?>