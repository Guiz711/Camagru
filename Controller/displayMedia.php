<?php

function display_Likes($img_id, $user_id, $where) {
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
    echo "<div class='all_about_like' id=$where;allAboutLike$img_id>";
    if ($nb_likes != 0)
        echo "<div class='nb_likes' id=$where;nbLikes$img_id>$nb_likes</div>";
    if ($_SESSION['user_id'] !== 'unknown') {
        echo "<div class='add_like' id=$where;handleLike$img_id>
            <a id='$where;$action;$img_id;$user_id' href='#' onClick='handleLike(this.id)'>
            <img src='$heart' class='like'></a>
            </div>
            <script src='./Controller/display.js'></script>";
    }
    else 
        echo "<div class='add_like'><img src='$heart' class='like'></a></div>";
    echo "</div>";
}

function display_Comments($img_id, $user_id, $where) {
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
    $nb_comments_todisplay = $CommentsManager->count_id(TRUE, "img_id", $img_id) - 1;
    echo "<div class=comment_part id=$where;commentPart$img_id>";
    // Nb Comments (IF)
    if ($nb_comments_todisplay > 0) {
        echo "<div class='show_comment' id='$where;showComment$img_id'><a href='#'id='$where;displayComment;$img_id;$user_id' onClick='displayComment(this.id)'>Afficher $nb_comments_todisplay commentaire(s)</a></div>";
    }
        // Display All Comments (IF)
    if ($nb_comments_todisplay > -1) {
        $lastComment = $CommentsManager->find_last($img_id);
        $findAuthorComment = $UsersManager->find_login($lastComment[0]['user_id']);
        $author = $findAuthorComment[0]['u_login'];
        $created = $lastComment[0]['date_creation'];
        $text = $lastComment[0]['text_comment'];
        echo "<div class='one_comment' id=$where;lastComment$img_id>";
        echo "<span class='created'>$created</span>
        <span class='author'>$author</span>
        <span class='commentText'>$text</span>
        </div>";
    }
        // Add New Comment (IF)
    if ($_SESSION['user_id'] !== 'unknown') {
        echo "<div class='add_comment' id=$where;addComment$img_id>
        <input class='input_comment' type=text id='$where;textComment;$img_id;$user_id'>
        <div class='input_add' ><a href='#' id='$where;addComment;$img_id;$user_id' onClick='addComment(this.id)'> Ajouter</a></div></div>";
    }
    echo "<script src='./Controller/display.js'></script></div></div></div>";
}

function display_one_media($img_id, $user_id, $media)
{
    $LikesManager = new LikesManager();
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
        
    $findAuthorId = $UsersManager->find_login($media['user_id']);
    $ImgAuthorLogin = $findAuthorId[0]['u_login'];
    $description = $media['img_description'];

    // Display IMG
    echo "<div class=media id=index_media$img_id>
        <div class='on_picture' id='index;on_picture;$img_id'>
        <div class='picture' id='index;picture;$img_id'>
        <img class='img' id='index;img;$img_id' src='$media[path_img]' height=1000px onClick='displayImage(this.id)'>
        <div class='hover_bottom hidden' id='hover_bottom$img_id' hidden'>
        <div class='created_by' id='index;author$img_id'>Posté par $ImgAuthorLogin </div>";
    if ($user_id == $media['user_id']) {
        echo "<div class='trash' id=index;deleteImg$img_id>
            <a id='index;deleteImg;$img_id;$user_id' href='#' onClick='deleteImg(this.id)'>
            <img src='./resources/trash.png'></a></div>
            <script language='JavaScript' type='text/javascript' src='./Controller/display.js'></script>";
    };
    echo "</div></div></div>
        <div class='index_info_picture'>";
    
    // Display LIKES
    display_Likes($img_id, $user_id, "index");
    // Display COMMENTS
    display_Comments($img_id, $user_id, "index");

    // Display POPUP
    echo "<div class=popup_media id=popup_media$img_id onClick='undisplayPopup(this.id)'>
        <div class='on_picture' id='popup;on_picture;$img_id'>
        <div class='picture' id='popup;picture;$img_id'>
        <img class='img' id='popup;img;$img_id' src='$media[path_img]' height=1000px onClick='undisplayImage(this.id)'>
        </div></div>
        <div class='info_picture'>
        <div class='created_by' id='popup;author$img_id'>Posté par $ImgAuthorLogin </div>
        <div class ='description' id='description$img_id'>Description : $description</div>";
    // Display LIKES
    display_Likes($img_id, $user_id, "popup");
    // Display COMMENTS        
    display_Comments($img_id, $user_id, "popup");    
}

function display_index()
{
    if (!$_SESSION || !array_key_exists('display_id', $_SESSION))
        $_SESSION['display_id'] = 1;
    $display_id = $_SESSION['display_id'];
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(FALSE, FALSE, "date_creation DESC");
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);
    $limit = $display_id * 10;
    foreach ($all_imgs as $key => $value) {
        if ($key < $limit) {
            $img_id = $value['img_id'];
            $media = $value;
            display_one_media($img_id, $user_id, $media);
        }
    }
    // Display Button Display MORE
    $nb_total_imgs = $ImagesManager->count_id(False, null, null);
    if ($nb_total_imgs > $limit) {
        echo "</div><div class='button-displayMore' id=displayMore1>
        <a id='index;displayMore;$display_id' href='#' onClick='displayMore(this.id)'>
        Afficher +</a>
        </div>
        <script src='./Controller/display.js'></script>";
    }
}

function display_myprofile()
{
    if (!$_SESSION || !array_key_exists('display_id', $_SESSION))
        $_SESSION['display_id'] = 1;
    $display_id = $_SESSION['display_id'];
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation desc LIMIT 10");
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);
    $limit = $display_id * 10;
    foreach ($all_imgs as $key => $value) {
        if ($key < $limit) {
            $img_id = $value['img_id'];
            $media = $value;
            display_one_media($img_id, $user_id, $media);
        }
    }
    // Display Button Display MORE
    $nb_total_imgs = $ImagesManager->count_id(True, 'user_id', $_SESSION['user_id']);
    if ($nb_total_imgs > $limit) {
        echo "</div><div class='button-displayMore' id=displayMore1>
        <a id='profile;displayMore;$display_id' href='#' onClick='displayMore(this.id)'>
        Affichez +</a>
        </div>
        <script src='./Controller/display.js'></script>";
    }
}

function display_photomontage()
{
    $LikesManager = new LikesManager();
    $CommentsManager = new CommentsManager();
    $UsersManager = new UsersManager();
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(array('user_id' => $_SESSION['user_id']), FALSE, "date_creation DESC LIMIT 5"); 
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);
    foreach ($all_imgs as $key => $value) {
        $img_id = $value['img_id'];
        $media = $value;
		$findAuthorId = $UsersManager->find_login($media['user_id']);
    	$ImgAuthorLogin = $findAuthorId[0]['u_login'];
    	$description = $media['img_description'];
        echo "<div class=media id=photo$img_id>
            <div class='on_picture' id='photo;on_picture;$img_id'>
            <div class='picture' id='photo;picture;$img_id'>
            <img src='$media[path_img]' height=1000px >
			<div class='hover_bottom hidden' id='hover_bottom$img_id' hidden'>
			<div class='created_by' id='photo;author$img_id'>Posté par $ImgAuthorLogin </div>";
		if ($user_id == $media['user_id']) {
			echo "<div class='trash' id=photo;deleteImg$img_id>
				<a id='photomontages_last;deleteImg;$img_id;$user_id' href='#' onClick='deleteImg(this.id)'>
                <img src='./resources/trash.png'></a></div>";
		};
		echo "<script language='JavaScript' type='text/javascript' src='./Controller/display.js'></script></div></div></div></div>";
    }
}

function display_filters()
{
    echo "<div id='filter1'><img class='filterimg' src='./resources/filters/1.png' ></div>";
    echo "<div id='filter2'><img class='filterimg' src='./resources/filters/2.png' ></div>";
    echo "<div id='filter3'><img class='filterimg' src='./resources/filters/3.png' ></div>";
    echo "<div id='filter4'><img class='filterimg' src='./resources/filters/4.png' ></div>";
}


function deleteImg($img_id, $where) {
 
	if (!isset($_SESSION))
		session_start();
	$vault = true;
    include("./allIncludes.php");
    $ImagesManager = new ImagesManager();
    $ImagesManager->delete(array('img_id' => $img_id));
    $LikesManager = new LikesManager();
    $LikesManager->delete(array('img_id' => $img_id));
    $CommentsManager = new CommentsManager();
    $CommentsManager->delete(array('img_id' => $img_id));
    if ($where == "content_index")
        display_index();
    else if ($where == 'content_profile')
        display_myprofile();
    else if ($where == 'photomontages_last')
        display_photomontage();
}

function display_more($id)
{    
	if (!isset($_SESSION))
		session_start();
	$vault = true;
    include("./allIncludes.php");   
    $start = $id * 10;
    $limit = $start + 10;
    $ImagesManager = new ImagesManager();
    $all_imgs = $ImagesManager->select_all(FALSE, FALSE, "date_creation DESC");
    $user_id = $_SESSION['user_id'];
    $all_imgs = add_path_img($all_imgs);
    foreach ($all_imgs as $key => $value) {
        if ($key >= $start && $key < $limit) {
            $img_id = $value['img_id'];
            $media = $value;
            display_one_media($img_id, $user_id, $media, $id);
        }
    }
    $_SESSION['display_id'] = $id + 1;
}

function is_moretoDisplay($nb) 
{
	if (!isset($_SESSION))
		session_start();
	$vault = true;
    include("./allIncludes.php");
    $ImagesManager = new ImagesManager();
    $nb_img = $ImagesManager->count_id(FALSE, NULL, NULL);
    $ret = 0;
    if ($nb_img > ($nb + 1) * 10)
        $ret = 1;
    echo $ret;
}

function sanitize_input2($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

if ($_POST && array_key_exists('action', $_POST) && $_POST['action'] == 'displayMore')
    display_more(sanitize_input2($_POST['nb']));
else if ($_POST && array_key_exists('action', $_POST) && $_POST['action'] == 'IsMoreDisplay')
    is_moretoDisplay(sanitize_input2($_POST['nb']));
else if ($_POST && array_key_exists('action', $_POST) && $_POST['action'] == 'deleteImg')
    deleteImg(sanitize_input2($_POST['img_id']), sanitize_input2($_POST['where']));
?>