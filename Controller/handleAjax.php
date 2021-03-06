<?php
session_start();
$vault = true;

// INCLUDES

// CONFIG
require_once("../Config/database.php");
require_once('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASSWORD', $DB_PASSWORD);
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
require_once("../Controller/displayMedia.php");

function handle_like($img_id, $user_id, $data, $post) 
{
    $LikesManager = new LikesManager();
    $where = sanitize_input($post['where']);
    $action = sanitize_input($post['action']);
     // Handle New Likes
    if ($action == 'addLike') {
        $LikesManager->insert($data);
    }
    else if ($action == 'killLike') {
        $id_to_delete = $LikesManager->select_all($data, "AND", FALSE);
        $tab = array('like_id' => $id_to_delete[0]['like_id']);
        $LikesManager->delete($tab);
    }
    // Update Like && NbLikes
    $is_liked = $LikesManager->is_already_in_bdd(array('img_id' => $img_id, 'user_id' => $user_id), "AND", FALSE);
    // echo "is liked in $where = $is_liked";
    if ($is_liked == true) {
        $action = 'killLike';
        $heart = './resources/002-hearts.png';
    }
    else {
        $action = 'addLike';
        $heart = "./resources/001-favorite.png";
    }
    $to_print = "<div class='add_like' id=$where;handleLike$img_id><a id='$where;$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
                <img src='$heart' class='like'></a></div>
                <script src='./Controller/display.js'></script>";
    $nbLikes = $LikesManager->count_id(TRUE, "img_id", $img_id);
    if ($nbLikes > 0) {
        $nbLikes = "<div class=\"nb_likes\" id=\"$where;nbLikes$img_id\">$nbLikes</div>";
		$to_print = $nbLikes . $to_print;
	}
    echo $to_print;
}

function handle_comments($img_id, $user_id, $data, $post) 
{
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
    // Handle Comments
    $action = sanitize_input($post['action']);
    $is_displayed = sanitize_input($post['is_displayed']);
    $text_comment = sanitize_input($post['text_comment']);
    $to_print = "";
    $where = sanitize_input($post['where']);

    // INSERT Comment
    if ($action == 'addComment') {
        if ($text_comment != "") {
            $data['text_comment'] = $text_comment;
            $CommentsManager->insert($data);
        }
    }
    // Has to Be Displayed ?
    if ($action == 'displayComment')
        $is_displayed = 'true';
    else if ($action == 'undisplayComment')
        $is_displayed = 'false';
    if ($is_displayed == 'false') {
        $nbComments = $CommentsManager->count_id(TRUE, "img_id", $img_id) - 1;
        // Display 'Afficher Comments' + Update Nb Comment
        if ($nbComments > 0) {
            $to_print = "<div class='show_comment' id='$where;showComment$img_id'><a href='#'id='$where;displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher $nbComments commentaire(s)</a></div>";
        }
        // Display Last Comment
        $lastComment = $CommentsManager->find_last($img_id);
        $findAuthorComment = $UsersManager->find_login($lastComment[0]['user_id']);
        $author = $findAuthorComment[0]['u_login'];
        $created = $lastComment[0]['date_creation'];
        $text = $lastComment[0]['text_comment'];
        $to_print .= "<div class='one_comment' id=$where;lastComment$img_id>";
        $to_print .= "<span class='created'>$created</span>
                    <span class='author'>$author</span>
                    <span class='commentText'>$text</span></div>
                    <div class='add_comment'></div>";
    }
    else {
        $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');
        // Display 'Fermer les commentaires'
        $to_print = "<div class='show_comment' id='$where;showComment$img_id'><a href='#'id='$where;undisplayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Fermer les commentaires</a></span></div>";
        // Display All Comments
        foreach ($all_comments as $key => $value) {
            $findAuthorComment = $UsersManager->find_login($value['user_id']);
            $author = $findAuthorComment[0]['u_login'];
            $created = $value['date_creation'];
            $text = $value['text_comment'];
            $to_print .= "<div class='one_comment'>";
            $to_print .= "<span class='created'>$created</span>
                        <span class='author'>$author</span>
                        <span>$text</span></div>";
        }
	}
	if ($user_id != "unknown") {
        $to_print .= "<div class='add_comment' id=$where;addComment$img_id>
                    <input class='input_comment' type=text id='$where;textComment;$img_id;$user_id'>
					<div class='input_add'><a href='#' id='$where;addComment;$img_id;$user_id' onClick='addComment(this.id)'>Ajouter</a></div></div>
					<script src='./Controller/display.js'></script>";
    }
    echo $to_print;
}


if (!isset($_SESSION) || !isset($_POST) || !array_key_exists('user_id', $_SESSION) || !array_key_exists('user_id', $_POST) || $_SESSION['user_id'] != $_POST['user_id'])
    die();
else if ($_SESSION['user_id'] == 'unknown' && $_POST['action'] != 'displayComment' && $_POST['action'] != 'undisplayComment')
    die();

$img_id = sanitize_input($_POST['img_id']);
$user_id = sanitize_input($_POST['user_id']);
$action = sanitize_input($_POST['action']);
$post = $_POST;

if ($action == 'addLike' || $action == 'killLike' || $action == 'updateLike') {
    $data = array('user_id' => $user_id, 'img_id' => $img_id);
    handle_like($img_id, $user_id, $data, $post);
}
else {
    if ($action == 'addComment'){
        $data = array('user_id' => $user_id, 'img_id' => $img_id);
        sendMailComment($img_id);
    }
    else
        $data = null;
    handle_comments($img_id, $user_id, $data, $post);
}
?>