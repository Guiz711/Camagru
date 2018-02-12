<?php

// INCLUDES


// CONFIG
require_once("../Config/database.php");
require_once('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);

// VIEW
require_once("../View/path_img.php");

// MODEL
require_once("../Model/DbManager.class.php");
require_once("../Model/SelectElem.class.php");
require_once("../Model/ImagesManager.class.php");
require_once("../Model/CommentsManager.class.php");
require_once("../Model/LikesManager.class.php");
require_once("../Model/UsersManager.class.php");

// CONTROLLER
require_once("../Controller/utility.php");
require_once("../Controller/userForm.php");

// DEBUG

require_once("../DEBUG_print.php");


// echo "</br>POST</br>";
// print_r($_POST);


// SETUP des Variables

if ($_POST['action'] == 'addLike' || $_POST['action'] == 'killLike') {
    $LikesManager = new LikesManager();
}
else {
    $CommentsManager = new CommentsManager();
}


$img_id = $_POST['img_id'];
$user_id = $_POST['user_id'];
$to_print = "";


if ($_POST['action'] == 'addComment' || $_POST['action'] == 'addLike' || $_POST['action'] == 'killLike') {
    $data = array('user_id' => $user_id, 'img_id' => $img_id);
}

// ACTIONS


// Like or Unlike
if ($_POST['action'] == 'addLike' || $_POST['action'] == 'killLike') {

    // Handle New Likes
    if ($_POST['action'] == 'addLike') {
        $LikesManager->insert($data);
        $action = 'killLike';
        $heart = './resources/002-hearts.png';
        $to_print = "<div class='add_like' id=handleLike$img_id><a id='$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
        <img src='$heart'></a></div>";
    }
    else if ($_POST['action'] == 'killLike') {
        $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
        $tab = array('like_id' => $id_to_delete[0]);
        $heart = "./resources/001-favorite.png";
        $LikesManager->delete($tab);
        $action = 'addLike';
        $to_print = "<a id='$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
        <img src='$heart'></a><script src='./Controller/display.js'></script>";
    }

    // Update NbLikes
    $nbLikes = $LikesManager->count_id(TRUE, "img_id", $img_id);
    if ($nbLikes > 1)
        $nbLikes .= ' Likes';
    else
        $nbLikes .= ' Like';
    $nbLikes .= "</div><div class='add_like' id=handleLike$img_id>";
    $to_print = $nbLikes . $to_print;
}
else {

 // Handle Comments

    $UsersManager = new UsersManager();
    $action = $_POST['action'];

    if ($_POST['action'] == 'addComment') {

        // Insert New Comment
        $data['text_comment'] = $_POST['text_comment'];
        $CommentsManager->insert($data);
    }

    // Has to Be Display ?

    if ($_POST['action'] == 'displayComment')
        $_POST['is_displayed'] = 'true';
    else if ($_POST['action'] == 'undisplayComment')
        $_POST['is_displayed'] = 'false';

    // Find All Comments
    $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');
    foreach ($all_comments as $key => $value) {
        $user_login = $value['user_id'];
        $result = $UsersManager->select_all(array('user_id' => $user_login), FALSE, FALSE);
        $all_comments[$key]['u_login'] = $result[0]['u_login'];
    }

    if ($_POST['is_displayed'] == 'false') {
        
        $nbComments = count($all_comments) - 1;

        // Display 'Afficher Comments' + Update Nb Comment
        if ($nbComments > 0) {
            $to_print = "<div class='show_comment' id='showComment$img_id'><a href='#'id='displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher 
        <span class='nb_comments' id=nbComments$img_id>$nbComments Comment(s)</a></span></div>";
        }

        // Display Last Comment
        $author = $all_comments[$nbComments]['u_login'];
        $created = $all_comments[$nbComments]['date_creation'];
        $text = $all_comments[$nbComments]['text_comment'];

        $to_print .= "<div class='one_comment' id=lastComment$img_id><span class='author'>$author</span>";
        $to_print .= "<span class='created'>$created</span><span>$text</span></div>
        <div class='add_comment'></div>";
    }
    else {
        // Display 'Fermer les commentaires'
        $to_print = "<div class='show_comment' id='showComment$img_id'><a href='#'id='undisplayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Fermer les comments</a></span></div>";

        // Display All Comments
        foreach ($all_comments as $key => $value) {
            $author = $value['u_login'];
            $created = $value['date_creation'];
            $text = $value['text_comment'];
            $to_print .= "<div class='one_comment'><span class='author'>$author</span>";
            $to_print .= "<span class='created'>$created</span><span>$text</span></div>";
        }
    }
    $to_print .= "<div class='add_comment' id=addComment$img_id>
                        <input type=text id='textComment;$img_id;$user_id'>
                        <div><a href='#' id='addComment;$img_id;$user_id' onClick='addComment(this.id)'>POST</a></div></div>
                        <script src='./Controller/display.js'></script>";
}

echo $to_print;

?>