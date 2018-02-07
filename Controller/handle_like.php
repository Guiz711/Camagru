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
    // echo "</br>POST</br>";
    // print_r($_POST);


    if ($_POST['action'] == 'addcomment')
        $CommentsManager = new CommentsManager();
    else
        $LikesManager = new LikesManager();
    $to_print = "test";
    $key = $_POST['img_id'];
    if ($_POST['action'] != 'updateNb') {
        $user_id = $_POST['user_id'];
        $data = array('user_id' => $_POST['user_id'], 'img_id' => $_POST['img_id']);
    }


    if ($_POST['action'] == 'like_it') {
        $LikesManager->insert($data);
        $action = 'unlike_it';
        $heart = './resources/002-hearts.png';
        $to_print = "<a id='$action;$key;$user_id' href='#' onClick='loadHeart(this.id)'>
        <img src='$heart'></a>";
    }
    else if ($_POST['action'] == 'unlike_it') {
        $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
        $tab = array('like_id' => $id_to_delete[0]);
        // echo "</br>ID TO DELTE</br>";
        // print_r($id_to_delete);
        $heart = "./resources/001-favorite.png";
        $LikesManager->delete($tab);
        $action = 'like_it';
        $to_print = "<a id='$action;$key;$user_id' href='#' onClick='loadHeart(this.id)'>
        <img src='$heart'></a>";
    }
    else if ($_POST['action'] == 'addcomment')
    {
        $data['text_comment'] = $_POST['text_comment'];
        $CommentsManager->insert($data);
        $action = 'addcomment';
        $to_print = "<input type=text id='textcomment;$key;$user_id'>
        <div><a href='#' id='addcomment;$key;$user_id' onClick='addComment(this.id)'>POST</a></div>";

    }
    else if ($_POST['action'] == 'updateNb') {
        $manager = "";
        if ($_POST['type'] == 'Like(s)') {
            $Manager = new LikesManager();
        }
        else if ($_POST['type'] == 'Comment(s)') {
            $Manager = new CommentsManager();
        }
        $to_print = $Manager->count_id(TRUE, "img_id", $_POST['img_id']);
        $to_print .= ' ' . $_POST['type'];
    }
    echo $to_print;
?>