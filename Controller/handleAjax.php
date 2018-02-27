<?php
if (!isset($_SESSION))
	session_start();
$vault = true;
// INCLUDES


// CONFIG
require_once("../Config/database.php");
require_once('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);

// VIEW
require_once("../View/path_img.php");
require_once("../View/view.php");
require_once("../View/signin.php");
require_once("../View/modify_user.php");

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

require_once("../Controller/displayMedia.php");
// echo "</br>POST</br>";
// print_r($post);


function handle_like($img_id, $user_id, $data, $post) 
{
    $LikesManager = new LikesManager();
    $where = $post['where'];

     // Handle New Likes
    if ($post['action'] == 'addLike') {
        $LikesManager->insert($data);
        $action = 'killLike';
        $heart = './resources/002-hearts.png';
        $to_print = "<div class='add_like' id=$where;handleLike$img_id><a id='$where;$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
        <img src='$heart' class='like'></a></div><script src='./Controller/display.js'></script>";
    }
    else if ($post['action'] == 'killLike') {
        $id_to_delete = $LikesManager->select_all($data, "AND", FALSE);
        $tab = array('like_id' => $id_to_delete[0]['like_id']);
        $heart = "./resources/001-favorite.png";
        $LikesManager->delete($tab);
        $action = 'addLike';
        $to_print = "<div class='add_like' id=$where;handleLike$img_id><a id='$where;$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
        <img src='$heart' class='like'></a></div><script src='./Controller/display.js'></script>";
    }
    // Update NbLikes
    $nbLikes = $LikesManager->count_id(TRUE, "img_id", $img_id);
    // if ($nbLikes > 1)
    //     $nbLikes .= ' Likes';
    // else
    //     $nbLikes .= ' Like';
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
    $to_print = "";
    $where = $post['where'];

    if ($post['action'] == 'addComment') {

        // Insert New Comment
        if ($post['text_comment'] != "") {
            $data['text_comment'] = sanitize_input($post['text_comment']);
            $CommentsManager->insert($data);
        }

    }

    // Has to Be Displayed ?

    if ($post['action'] == 'displayComment')
        $post['is_displayed'] = 'true';
    else if ($post['action'] == 'undisplayComment')
        $post['is_displayed'] = 'false';


    if ($post['is_displayed'] == 'false') {
        
        $nbComments = $CommentsManager->count_id(TRUE, "img_id", $img_id) - 1;

        // Display 'Afficher Comments' + Update Nb Comment
        if ($nbComments > 0) {
            $to_print = "<div class='show_comment' id='$where;showComment$img_id'><a href='#'id='$where;displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher 
        <span class='nb_comments' id=$where;nbComments$img_id>$nbComments Comment(s)</a></span></div>";
        }

        // Display Last Comment
        $lastComment = $CommentsManager->find_last($img_id);
        $findAuthorComment = $UsersManager->find_login($lastComment[0]['user_id']);

        $author = $findAuthorComment[0]['u_login'];
        $created = $lastComment[0]['date_creation'];
        $text = $lastComment[0]['text_comment'];

        $to_print .= "<div class='one_comment' id=$where;lastComment$img_id><span class='author'>$author</span>";
        $to_print .= "<span class='created'>$created</span><span>$text</span></div>
        <div class='add_comment'></div>";
    }
    else {

        $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');

        // Display 'Fermer les commentaires'
        $to_print = "<div class='show_comment' id='$where;showComment$img_id'><a href='#'id='$where;undisplayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Fermer les comments</a></span></div>";

        // Display All Comments
        foreach ($all_comments as $key => $value) {
            $findAuthorComment = $UsersManager->find_login($value['user_id']);
            $author = $findAuthorComment[0]['u_login'];
            $created = $value['date_creation'];
            $text = $value['text_comment'];
            $to_print .= "<div class='one_comment'><span class='author'>$author</span>";
            $to_print .= "<span class='created'>$created</span><span>$text</span></div>";
        }
	}
	if ($user_id != "unknown") {
		$to_print .= "<div class='add_comment' id=$where;addComment$img_id>
							<input type=text id='$where;textComment;$img_id;$user_id'>
							<div><a href='#' id='$where;addComment;$img_id;$user_id' onClick='addComment(this.id)'>POST</a></div></div>
							<script src='./Controller/display.js'></script>";
    }
    echo $to_print;
}

$img_id = sanitize_input($_POST['img_id']);
$user_id = sanitize_input($_POST['user_id']);

$post = $_POST;

if ($_POST['action'] == 'addLike' || $_POST['action'] == 'killLike') {
    $data = array('user_id' => $user_id, 'img_id' => $img_id);
    handle_like($img_id, $user_id, $data, $post);
}
else {
    if ($post['action'] == 'addComment'){
        $data = array('user_id' => $user_id, 'img_id' => $img_id);
        sendMailComment($img_id);
    }
    else
        $data = null;
    handle_comments($img_id, $user_id, $data, $post);
}


?>