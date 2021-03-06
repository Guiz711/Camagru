<?php
session_start();
$vault = true;
if (!array_key_exists('user_id', $_SESSION))
	$_SESSION['user_id'] = "unknown";
if ($_SESSION['user_id'] === "unknown")
{
	header('location: ../index.php');
	die();
}

require_once("../Config/database.php");
require_once('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASSWORD', $DB_PASSWORD);
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
include("../Controller/displayMedia.php");

//View
require_once("../View/path_img.php");

function insert_filters($ids_array, $img_data)
{
	$img_src = @imagecreatefromstring($img_data);
	if ($img_src === false)
		return (false);
    $img = imagecreatetruecolor(655, 491);
    header('Content-type: image/jpeg');
    $ratio = bcdiv('491.0', '655.0', 3);
    $width = imagesx($img_src);
    $height = imagesy($img_src);
    if ($width < $height) {
        $new_height = bcmul($width, $ratio, 3);
        $pos_x = 0;
        $pos_y = bcdiv(bcsub($height, $new_height, 3), '2.0', 3);
        $height = $new_height;
    }
    else {
        $new_width = bcdiv($height, $ratio, 3);
        $pos_x = bcdiv(bcsub($width, $new_width, 3), '2.0', 3);
        $pos_y = 0;
        $width = $new_width;
    }
    imagecopyresampled($img, $img_src, 0, 0, $pos_x, $pos_y, 655, 491, $width, $height);
    foreach ($ids_array as $id) {
        $filter = imagecreatefrompng("../resources/filters/$id.png");
        imagecopy($img, $filter, 0, 0, 0, 0, imagesx($filter), imagesy($filter));
    }
    return ($img);
}

if (array_key_exists('ids', $_POST) && $_POST['ids'] == "") 
	die();
if (array_key_exists('image', $_POST) && array_key_exists('description', $_POST) && array_key_exists('ids', $_POST)) {
    $ImagesManager = new ImagesManager();
    $image = substr(sanitize_input($_POST['image']), strpos(sanitize_input($_POST['image']), ','));
    $image = str_replace(' ', '+', $image);
	$image = insert_filters(explode(';', sanitize_input($_POST['ids'])), base64_decode($image));
	if (!$image) {
		echo "ERROR";
		die();
	}
    $ImagesManager->insert(array(
        'user_id' => $_SESSION['user_id'],
        'img_description' => sanitize_input($_POST['description'])
	));
    $image_name = $ImagesManager->userLastImage($_SESSION['user_id']);
    imagepng($image, '../img/' . $image_name . '.png');
    display_photomontage();
 } 
else {
    header('location: ../index.php');
	die();
}
?>