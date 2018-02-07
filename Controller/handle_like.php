<?php

// if ($_SESSION['user_id']='unknow') {
//     echo "HEY you need to signin first";
// }
// else {
// header("Content-Type: text/plain");
// echo "truc";
// CONFIG
include("../Config/database.php");
include('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);

// VIEW
// include("../View/signin.php");
include("../View/path_img.php");

// MODEL
include("../Model/DbManager.class.php");
include("../Model/SelectElem.class.php");
include("../Model/ImagesManager.class.php");
include("../Model/CommentsManager.class.php");
include("../Model/LikesManager.class.php");
include("../Model/UsersManager.class.php");

// CONTROLLER
include("../Controller/utility.php");
include("../Controller/userForm.php");

// DEBUG

include("../DEBUG_print.php");
    
    if ($POST['action'] == 'addcomment')
        $CommentsManager = new LikesManager();
    else
        $LikesManager = new CommentssManager();
    $to_print = "test";
    $user_id = $POST['user_id'];
    $key = $POST['img_id'];
    $data = array('user_id' => $POST['user_id'], 'img_id' => $POST['img_id']);
    // echo "</br>POST</br>";
    // print_r($_POST);
    // }
    if ($POST['action'] == 'like_it') {
        $LikesManager->insert($data);
        $action = 'unlike_it';
        $heart = './resources/002-hearts.png';
        $to_print = "<a id='$action;$key;$user_id' href='#' onClick='loadMedia(this.id)'>
        <img src='$heart'></a>";
    }
    else if ($POST['action'] == 'unlike_it') {
        $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
        $tab = array('like_id' => $id_to_delete[0]);
        $heart = "./resources/001-favorite.png";
        $LikesManager->delete($tab);
        $action = 'like_it';
        $to_print = "<a id='$action;$key;$user_id' href='#' onClick='loadMedia(this.id)'>
        <img src='$heart'></a>";
    }
    else if ($POST['action'] == 'addcomment')
    {
        $CommentsManager->insert($data);
        $action = 'addcomment';
        $to_print = "<input type=text id='addcomment;$key;$user_id' href='#' onClick='addcomment(this.id)'>";

    }
    echo $to_print;

?>