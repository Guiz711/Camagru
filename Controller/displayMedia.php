<?php
    session_start();

function display_Likes($img_id, $user_id) {
     
    // Gestion des LIKES
     $LikesManager = new LikesManager();
     $var = array('img_id' => $img_id, 'user_id' => $user_id);

     if ($user_id != "unknown" && $LikesManager->is_already_in_bdd($var, 'AND', FALSE) == TRUE) {
        $heart = "./resources/002-hearts.png";
        $action = "killLike";
    }
    else {
        $heart = "./resources/001-favorite.png";
        $action = "addLike";
    }

    $nb_likes = $LikesManager->count_id(TRUE, "img_id", $img_id);

    echo "<div class='all_about_like' id=allAboutLike$img_id>";
    
            // Nb Likes
        echo "<div class='nb_likes' id=nbLikes$img_id>$nb_likes";
        if ($nb_likes < 2) 
            echo " Like</div>";
        else 
            echo " Likes</div>";
    
            // Display Heart (IF)
        if ($_SESSION['user_id'] !== 'unknown') {
            echo "<div class='add_like' id=handleLike$img_id>
            <a id='$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
            <img src='$heart' class='like'></a>
            </div>
            <script src='./Controller/display.js'></script>";
        }
        else {
            echo "<div class='add_like'><img src='$heart' class='like'></a></div>";
        }
        echo "</div>";
}

function display_Comments($img_id, $user_id) {

    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
    $nb_comments_todisplay = $CommentsManager->count_id(TRUE, "img_id", $img_id) - 1;

    echo "<div class=comment_part id=commentPart$img_id>";

    // Nb Comments (IF)
    if ($nb_comments_todisplay > 0) {
        echo "<div class='show_comment' id='showComment$img_id'><a href='#'id='displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher 
        <span class='nb_comments' id=nbComments$img_id>$nb_comments_todisplay Comment(s)</a></span></div>";
    }
        // Display All Comments (IF)
    if ($nb_comments_todisplay > -1) {

        $lastComment = $CommentsManager->find_last($img_id);
        $findAuthorComment = $UsersManager->find_login($lastComment[0]['user_id']);

        $author = $findAuthorComment[0]['u_login'];
        $created = $lastComment[0]['date_creation'];
        $text = $lastComment[0]['text_comment'];

        echo "<div class='one_comment' id=lastComment$img_id><span class='author'>$author</span>";
        echo "<span class='created'>$created</span><span>$text</span></div>";
    }

        // Add New Comment (IF)
    if ($_SESSION['user_id'] !== 'unknown') {
        echo "<div class='add_comment' id=addComment$img_id>
        <input type=text id='textComment;$img_id;$user_id'>
        <div><a href='#' id='addComment;$img_id;$user_id' onClick='addComment(this.id)'>POST</a></div></div>";
    }
    echo "<script src='./Controller/display.js'></script>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}


function display_one_media($img_id, $user_id, $media)
{

    $LikesManager = new LikesManager();
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();


    // foreach ($all_imgs as $value) {

    //     $img_id = $value['img_id'];
        
        $findAuthorId = $UsersManager->find_login($media['user_id']);
        $ImgAuthorLogin = $findAuthorId[0]['u_login'];

            // Display IMG
        echo "
        <div class=media id=media$img_id>
            <div class='on_picture'>
                <div class='picture'>
                    <div class='hover_top hidden'>
                    </div>
                    <img src='$media[path_img]' height=1000px >
                    <div class='hover_bottom hidden'>
                    </div>
                </div>
                <div class='info_picture'>";

            // Display TRASH (IF)
        if ($user_id == $media['user_id']) {
            echo "
                    <div class='trash' id=deleteImg$img_id>
                        <a id='deleteImg;$img_id;$user_id' href='#' onClick='deleteImg(this.id)'>
                        <img src='./resources/trash.png' class='trash'></a>
                    </div>
                    <script src='./Controller/display.js'></script>";
        }
        
            // Display LIKES
        display_Likes($img_id, $user_id);
    
            // Author (& Date ??)
        echo "<div class =created_by>Created by $ImgAuthorLogin </div></div>";

            // Display COMMENTS
        display_Comments($img_id, $user_id);
    // }
    // echo "</div>";
}


function display_index()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(FALSE, FALSE, "date_creation DESC LIMIT 3");

    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);

    foreach ($all_imgs as $key => $value) {
        $img_id = $value['img_id'];
        $media = $value;
        display_one_media($img_id, $user_id, $media);
    }
    // Display Button Display MORE
    $nb_total_imgs = $ImagesManager->count_id(False, null, null);
    if ($nb_total_imgs > 3) {
        echo "</div><div class='button-displayMore' id=displayMore1>
        <a id='displayMore;1' href='#' onClick='displayMore(this.id)'>
        Affichez +</a>
        </div>
        <script src='./Controller/display.js'></script>";
    }
}

function display_photomontage()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation desc");
    
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);

    foreach ($all_imgs as $key => $value) {
        $img_id = $value['img_id'];
        $media = $value;
        display_one_media($img_id, $user_id, $media);
    }
}

function display_myprofile()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation desc");
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);

    foreach ($all_imgs as $key => $value) {
        $img_id = $value['img_id'];
        $media = $value;
        display_one_media($img_id, $user_id, $media);
    }
}

if ($_POST['action'] == 'displayMore')
    display_more($_POST['nb']);

function display_more($id) {
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
    
    $start = $id * 10;
    $limit = $start + 10;
    echo "";
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(FALSE, FALSE, "date_creation DESC LIMIT $limit");

    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);

    foreach ($all_imgs as $key => $value) {
        if ($key >= 3) {
            $img_id = $value['img_id'];
            $media = $value;
            display_one_media($img_id, $user_id, $media);
        }
    }
    $id++;
    echo "</div><div class='button-displayMore' id=displayMore$id>
    <a id='displayMore;$id' href='#' onClick='displayMore(this.id)'>
    Affichez +</a>
    </div>
    <script src='./Controller/display.js'></script>";


}

?>