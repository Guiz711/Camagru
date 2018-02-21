<?php
session_start();

require_once("../Config/database.php");
require_once('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);

// MODEL
require_once("../Model/DbManager.class.php");
require_once("../Model/SelectElem.class.php");
require_once("../Model/ImagesManager.class.php");
require_once("../Model/CommentsManager.class.php");
require_once("../Model/LikesManager.class.php");
require_once("../Model/UsersManager.class.php");

// CONTROLLER
require_once("./utility.php");
require_once("./userForm.php");
// require_once("./uploadImage.php");
// include("./Controller/displayMedia.php");
// require_once("./Controller/handleAjax.php");

function insert_filters($ids_array, $img_data)
{
    $img = imagecreatefromstring($img_data);
    print_r($ids_array);
    foreach ($ids_array as $id) {
        $filter = imagecreatefrompng("../resources/filters/$id.png");
        imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter), imagesy($filter));
    }
    return ($img);
}

// echo "hey";
if (array_key_exists('image', $_POST) && array_key_exists('description', $_POST) && array_key_exists('ids', $_POST)) {
    $ImagesManager = new ImagesManager();
    $image = substr($_POST['image'], strpos($_POST['image'], ','));
    // $image = $_POST['image'];
    $image = str_replace(' ', '+', $image);
    $image = insert_filters(explode(';', $_POST['ids']), base64_decode($image));
    // $image = base64_decode($image);
    $ImagesManager->insert(array(
        'user_id' => $_SESSION['user_id'],
        'img_description' => $_POST['description']
    ));
    $image_name = $ImagesManager->userLastImage($_SESSION['user_id']);
    echo $image;
    imagepng($image, '../img/' . $image_name . '.png');
    // file_put_contents('../img/' . $image_name . '.png', $image);
} else {
    echo 'Ca fonctionne pas T_T';
}

?>