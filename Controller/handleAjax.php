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

if ($_POST['action'] == 'addComment')
    $CommentsManager = new CommentsManager();
else
    $LikesManager = new LikesManager();


$to_print = "";
$img_id = $_POST['img_id'];
$user_id = $_POST['user_id'];

if ($_POST['action'] == 'addComment' || $_POST['action'] == 'addLike' || $_POST['action'] == 'killLike') {
    $data = array('user_id' => $user_id, 'img_id' => $img_id);
}

// ACTIONS


if ($_POST['action'] == 'addLike') {
    $LikesManager->insert($data);
    $action = 'killLike';
    $heart = './resources/002-hearts.png';
    $to_print = "<a id='$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
    <img src='$heart'></a>";
}
else if ($_POST['action'] == 'killLike') {
    $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
    $tab = array('like_id' => $id_to_delete[0]);
    $heart = "./resources/001-favorite.png";
    $LikesManager->delete($tab);
    $action = 'addLike';
    $to_print = "<a id='$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
    <img src='$heart'></a>";
}
else if ($_POST['action'] == 'addComment')
{
    // echo "ACTION PHP -> addComment <br />";

    $data['text_comment'] = $_POST['text_comment'];
    $CommentsManager->insert($data);
    $action = $_POST['action'];
    $to_print = "<input type=text id='textComment;$img_id;$user_id'>
    <div><a href='#' id='addComment;$img_id;$user_id' onClick='addComment(this.id)'>POST</a></div>";
}
else if ($_POST['action'] == 'updateNb') {

    // echo "ACTION PHP -> updateNb <br />";

    $manager = "";
    if ($_POST['type'] == 'Like(s)') {
        $Manager = new LikesManager();
    }
    else if ($_POST['type'] == 'Comment(s)') {
        $Manager = new CommentsManager();
    }
    $to_print = $Manager->count_id(TRUE, "img_id", $img_id) - 1;
    $to_print .= ' ' . $_POST['type'];
}
else if ($_POST['action'] == 'refreshComment' || $_POST['action'] == 'displayComment') {
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
    $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');
        foreach ($all_comments as $img_id2 => $value2) {
            $user_login = $value2['user_id'];
            $result = $UsersManager->select_all(array('user_id' => $user_login), FALSE, FALSE);
            $all_comments[$img_id2]['u_login'] = $result[0]['u_login'];
        }
    $count = count($all_comments) - 1;
    if ($_POST['action'] == 'refreshComment') {
        $author = $all_comments[$count]['u_login'];
        $created = $all_comments[$count]['date_creation'];
        $text = $all_comments[$count]['text_comment'];
        $to_print = "<span class='author'>$author</span><span class='created'>$created</span><span>$text</span>";
    }
    else if ($_POST['action'] == 'displayComment') {
        unset($all_comments[$count]);
        // DEBUG_print($all_comments);
        $to_print= '';
        foreach ($all_comments as $img_id => $value) {
            // echo "In foreach";
            $author = $value['u_login'];
            $created = $value['date_creation'];
            $text = $value['text_comment'];
            $img_id = $_POST['img_id'];
            $to_print .= "<div class='one_comment'><span class='author'>$author</span><span class='created'>$created</span><span>$text</span></div>
        <div class='add_comment'></div>";
        }
        $to_print .= "<a href='#' id='undisplayComment;$img_id' onClick='displayComment(this.id)'>Fermer les autres comments</a>";
    }
}
else if ($_POST['action'] == 'undisplayComment') {
    $img_id = $_POST['img_id'];
    $Manager = new CommentsManager();
    $nb_comments_todisplay = $Manager->count_id(TRUE, "img_id", $img_id) - 1;
    $to_print= "<a href='#'id='displayComment;$img_id' onClick='displayComment(this.id)'>Afficher 
    <span class='nb_comments' id=nbcomments;$img_id>$nb_comments_todisplay Comment(s)</a>";
}
echo $to_print;
?>