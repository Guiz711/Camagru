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
    //    echo "</br>POST</br>";
    //    print_r($_POST);

// if (array_key_exists('action', $_POST)) {
//     $_SESSION['scroll'] = 'img_id' . $_POST['img_id'];
//     echo "SET UP Scroll : " . $_SESSION['scroll'] . "</br >";
// }

    if ($_POST['action'] == 'addcomment')
        $CommentsManager = new CommentsManager();
    else
        $LikesManager = new LikesManager();


    $to_print = "test";
    $key = $_POST['img_id'];

    if ($_POST['action'] == 'addcomment' || $_POST['action'] == 'like_it' || $_POST['action'] == 'unlike_it') {
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
    else if ($_POST['action'] == 'refreshComment' || $_POST['action'] == 'displayComment') {
        $CommentsManager = new CommentsManager();
        $UsersManager = new UsersManager();
        $img_id = $_POST['img_id'];
        $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');
			foreach ($all_comments as $key2 => $value2) {
                $user_login = $value2['user_id'];
                $result = $UsersManager->select_all(array('user_id' => $user_login), FALSE, FALSE);
                $all_comments[$key2]['u_login'] = $result[0]['u_login'];
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
                foreach ($all_comments as $key => $value) {
                    // echo "In foreach";
                    $author = $value['u_login'];
                    $created = $value['date_creation'];
                    $text = $value['text_comment'];
                    $img_id = $_POST['img_id'];
                    $to_print .= "<div class='one_comment'><span class='author'>$author</span><span class='created'>$created</span><span>$text</span></div>
                <div class='add_comment'></div>";
                }
                $to_print .= "<a href='#' id='undisplaycomment;$img_id' onClick='undisplayComment(this.id)'>Fermer les autres comments</a>";
            }
        }
        else if ($_POST['action'] == 'undisplayComment') {
            $key = $_POST['img_id'];
            $Manager = new CommentsManager();
            $nb_comments_todisplay = $Manager->count_id(TRUE, "img_id", $key) - 1;
            $to_print= "<a href='#'id='displaycomment;$key' onClick='displayComment(this.id)'>Afficher 
            <span class='nb_comments' id=nbcomments;$key>$nb_comments_todisplay Comment(s)</a>";
        }
    echo $to_print;
?>