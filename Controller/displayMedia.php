<?php
    session_start();

function display_media($ImagesManager, $all_imgs)
{

    $LikesManager = new LikesManager();
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();

    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);
    $i = 1;


    foreach ($all_imgs as $value) {

    // Set up Values utiles pour display dans HTML

    $img_id = $value['img_id'];
    $var = array('img_id' => $img_id, 'user_id' => $user_id);

    // Gestion des LIKES
    if ($user_id != "unknown" && $LikesManager->is_already_in_bdd($var, 'AND', FALSE) == TRUE) {
        $heart = "./resources/002-hearts.png";
        $action = "killLike";
    }
    else {
        $heart = "./resources/001-favorite.png";
        $action = "addLike";
    }
    $nb_likes = $LikesManager->count_id(TRUE, "img_id", $img_id);

    // Gestion des COMMENTS
    $nb_comments_todisplay = $CommentsManager->count_id(TRUE, "img_id", $img_id) - 1;
    if ($nb_comments_todisplay > -1) {
        $all_comments = $CommentsManager->select_all(array('img_id' => $img_id), FALSE, 'date_creation ASC');
        // Ajoute Infos des Comments
        foreach ($all_comments as $key => $value2) {
                $author_id = $value2['user_id'];
                $result = $UsersManager->select_all(array('user_id' => $author_id), FALSE, FALSE);
                $all_comments[$key]['u_login'] = $result[0]['u_login'];
            }
    }

    // Echo des DIVS

        // Display IMG
    echo "<div class=media id=media$img_id><div class='on_picture'><div class='picture'><div class='hover_top hidden'></div><img src='$value[path_img]' height=1000px ><div class='hover_bottom hidden'></div></div>
    <div class='info_picture'>";

        // Display TRASH (IF)
    if ($user_id == $value['user_id']) {
        echo "<div class='trash' id=deleteImg$img_id>
        <a id='deleteImg;$img_id;$user_id' href='#' onClick='deleteImg(this.id)'>
        <img src='./resources/trash.png' class='trash'></a>
        </div>
        <script src='./Controller/display.js'></script>";
    }
    
        // Display LIKES
    echo "<div class='all_about_like' id=allAboutLike$img_id>";

            // Nb Likes
    echo "<div class='nb_likes' id=nbLikes$img_id>$nb_likes Like(s)</div>";

            // Affichage Coeur Clikable (ou pas)
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
            // Author (& Date ??)
    echo "<div class =created_by>Created by</div>
    </div>";


        // Display COMMENTS
    echo "<div class=comment_part id=commentPart$img_id>";
            // Nb Comments (IF)
    if ($nb_comments_todisplay > 0) {
        echo "<div class='show_comment' id='showComment$img_id'><a href='#'id='displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher 
            <span class='nb_comments' id=nbComments$img_id>$nb_comments_todisplay Comment(s)</a></span></div>";
    }
            // Display All Comments (IF)
    if ($nb_comments_todisplay > -1) {
        $count = count($all_comments) - 1;
        $author = $all_comments[$count]['u_login'];
        $created = $all_comments[$count]['date_creation'];
        $text = $all_comments[$count]['text_comment'];
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
    echo "</div>";
}


function display_index()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(FALSE, FALSE, "date_creation desc");
    display_media($ImagesManager, $all_imgs);
}

function display_photomontage()
{
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation desc");
    display_media($ImagesManager, $all_imgs);
}

?>