<?php
    session_start();

function display_media($ImagesManager, $all_imgs)
{

    $LikesManager = new LikesManager();
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();

    $all_imgs = add_path_img($all_imgs);
    $i = 1;
    foreach ($all_imgs as $key => $value) {


    // Set up Values utiles pour display dans HTML

    $heart = "./resources/001-favorite.png";
    $action = "addLike";
    $user_id = $_SESSION['user_id'];
    $var = array('img_id' => $key, 'user_id' => $_SESSION['user_id']);


    if ($_SESSION['user_id'] != "unknown" && $LikesManager->is_already_in_bdd($var, 'AND', FALSE) == TRUE) {
        $heart = "./resources/002-hearts.png";
        $action = "killLike";
    }
    $nb_likes = $LikesManager->count_id(TRUE, "img_id", $key);
    $nb_comments_todisplay = $CommentsManager->count_id(TRUE, "img_id", $key) - 1;
    if ($nb_comments_todisplay > -1) {
        $all_comments = $CommentsManager->select_all(array('img_id' => $key), FALSE, 'date_creation ASC');
        foreach ($all_comments as $key2 => $value2) {
                $user_login = $value2['user_id'];
                $result = $UsersManager->select_all(array('user_id' => $user_login), FALSE, FALSE);
                $all_comments[$key2]['u_login'] = $result[0]['u_login'];
            }
    }

    // Echo des DIVS

    echo "<div class=media id=media$key>
        <div class='on_picture'><div class='picture'><div class='hover_top hidden'></div><img src='$value' height=1000px ><div class='hover_bottom hidden'></div></div>
        
        <div class='info_picture'>
        <div class='all_about_like' id=allAboutLike$key>
        <div class='nb_likes' id=nbLikes$key>$nb_likes Like(s)</div>";

        // Affichage Coeur Clikable (ou pas)
        if ($_SESSION['user_id'] !== 'unknown') {
            echo "<div class='add_like' id=handleLike$key>
            <a id='$action;$key;$user_id' href='#' onClick='handleLike(this.id)'>
            <img src='$heart' class='like'></a>
            </div>
            <script src='./Controller/display.js'></script>";
        }
        else {
            echo "<div class='add_like'><img src='$heart' class='like'></a></div>";
        }
        echo "</div>
        <div class =created_by>Created by</div>
        </div>";

        // Affichage Comments
        echo "<div class=comment_part id=commentPart$key>";
        if ($nb_comments_todisplay > 0) {
            echo "<div class='show_comment' id='showComment$key'><a href='#'id='displayComment;$key;$user_id' onClick='displayComment(this.id)'>Afficher 
                <span class='nb_comments' id=nbComments$key>$nb_comments_todisplay Comment(s)</a></span></div>";
        }
        if ($nb_comments_todisplay > -1) {
            $count = count($all_comments) - 1;
            $author = $all_comments[$count]['u_login'];
            $created = $all_comments[$count]['date_creation'];
            $text = $all_comments[$count]['text_comment'];
                echo "<div class='one_comment' id=lastComment$key><span class='author'>$author</span>";
                echo "<span class='created'>$created</span><span>$text</span></div>";
        }
        if ($_SESSION['user_id'] !== 'unknown') {
            echo "<div class='add_comment' id=addComment$key>
            <input type=text id='textComment;$key;$user_id'>
            <div><a href='#' id='addComment;$key;$user_id' onClick='addComment(this.id)'>POST</a></div></div>";
        }
    echo "<script src='./Controller/display.js'></script>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    }
    echo "</div>";
}


function display_index()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all_id(FALSE, FALSE, "date_creation desc");
    display_media($ImagesManager, $all_imgs);
}

function display_photomontage()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all_id(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation desc");
    display_media($ImagesManager, $all_imgs);
}

?>