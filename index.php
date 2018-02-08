<?php	
	session_start();
	print_r($_SESSION);
	if (!array_key_exists('user_id', $_SESSION))
		$_SESSION['user_id'] = "unknown";

?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="./View/style_css/style.css"> -->
	<title>Camagru</title>
	<meta charset="UTF-8">
</head>
<body>

	<header>

	<?php
	require("./requirements.php");
	if ($_SESSION["user_id"] !== "unknown")
	{
		include("./View/header_user.html");
	}
	else
	{
		include("./View/header_visitor.html");
	
	}
?>

	</header>
	<div class="img_gallery">
        <div class="content">
		<?php
		//  header('Content-Type: text/html; charset=utf-8');
			$ImagesManager = new ImagesManager();
			$LikesManager = new LikesManager();
			$CommentsManager = new CommentsManager();
			$UsersManager = new UsersManager();
			$all_imgs = $ImagesManager->select_all_id(FALSE, FALSE, "date_creation desc");
			$all_imgs = add_path_img($all_imgs);
			// echo "<br /><br />All Images with Path :<br />";
			// print_r($all_imgs);
			// echo "<br /><br />LETS GO PUTS div MEDIA <br /><br />";
			$i = 1;
			foreach ($all_imgs as $key => $value) {
			
				// echo "<br /><br />ID IMG = $key <br /><br />";
				$heart = "./resources/001-favorite.png";
				$action = "like_it";
				$user_id = $_SESSION['user_id'];
				$var = array('img_id' => $key, 'user_id' => $_SESSION['user_id']);
				if ($_SESSION['user_id'] != "unknown" && $LikesManager->is_already_in_bdd($var, 'AND', FALSE) == TRUE) {
					$heart = "./resources/002-hearts.png";
					$action = "unlike_it";
				}
				$nb_likes = $LikesManager->count_id(TRUE, "img_id", $key);
				$nb_comments_todisplay = $CommentsManager->count_id(TRUE, "img_id", $key) - 1;
				if ($nb_comments_todisplay > -1) {
					//  echo "</br ></br >ALL COMMENTS</br >";
					$all_comments = $CommentsManager->select_all(array('img_id' => $key), FALSE, 'date_creation ASC');
					//  echo "</br ></br >IN     INEDEX     ALL COMMENTS</br >";
					//  DEBUG_print($all_comments);
					foreach ($all_comments as $key2 => $value2) {
							$user_login = $value2['user_id'];
							$result = $UsersManager->select_all(array('user_id' => $user_login), FALSE, FALSE);
							$all_comments[$key2]['u_login'] = $result[0]['u_login'];
						}
				}
				// echo "nb_likes = " . $nb_likes;
				// echo "nb_comments = " . $nb_comments;
				echo "<div class=media id=img_id$key><div class='on_piscture'><div class='picture'><img src='$value'></div>
					<div class='info_picture'>
					<div class='all_about_like'>
					<div class='nb_likes' id=nblikes$key>$nb_likes Like(s)</div>";
					if ($_SESSION['user_id'] !== 'unknown') {
						echo "<div class='add_like' id=addlike$key>
						<a id='$action;$key;$user_id' href='#' onClick='loadHeart(this.id)'>
						<img src='$heart'></a>
						</div>
						<script src='./Controller/display.js'></script>";
					}
					else {
						echo "<div class='add_like'><img src='$heart'></a></div>";
					}
					echo "</div>
					<div class =created_by>Created by</div>
					</div>
					<div class=comment_part id=comment_part$key>";
					if ($nb_comments_todisplay > 0) {
						echo "<div class='show_comment' id='show_comment$key'><a href='#'id='displaycomment;$key' onClick='displayComment(this.id)'>Afficher 
							<span class='nb_comments' id=nbcomments;$key>$nb_comments_todisplay Comment(s)</a></span></div>";
					}
					if ($nb_comments_todisplay > -1) {
						$count = count($all_comments) - 1;
						$author = $all_comments[$count]['u_login'];
						$created = $all_comments[$count]['date_creation'];
						$text = $all_comments[$count]['text_comment'];
							echo "<div class='one_comment' id=lastcomment$key><span class='author'>$author</span>";
							echo "<span class='created'>$created</span><span>$text</span></div>
						<div class='add_comment'></div> ";
					}
					if ($_SESSION['user_id'] !== 'unknown') {
						echo "<div class='add_comment' id=addcomment$key>
						<input type=text id='textcomment;$key;$user_id'>
						<div><a href='#' id='addcomment;$key;$user_id' onClick='addComment(this.id)'>POST</a></div></div>
						<script src='./Controller/display.js'></script>";
					}
				echo "</div>";
			 };
		// 	handleImages($all_imgs);
		// </script>";
		?>
		</div>
    </div>
	<?php include("./View/footer.html"); ?>

</body>
</html>