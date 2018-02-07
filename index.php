<?php	
	session_start();
//	if (!array_key_exists('user_id', $_SESSION))
		$_SESSION['user_id'] = "1";
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
	// if ($_SESSION["logged_on_user"] !== "")
	// {
	// 	include("header_user.html");
	// }
	// else
	// {
		include("./View/header_visitor.html");
	
	// }
?>

	</header>
<!-- Galerie d'images -->
    <!-- <section>
            <div class="img_gallery">
                        <div class="content">
                                <div class="media" ><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie1" /></a></div>
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div> 
                                <div class="media"><a href=""><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/2ChocolateChipCookies.jpg/1200px-2ChocolateChipCookies.jpg" alt="" title="Cookie3" /></a></div>                           
                        </div>
                        </div>
    </section> -->


	<div class="img_gallery">
        <div class="content">
		<?php
		//  header('Content-Type: text/html; charset=utf-8');
			$ImagesManager = new ImagesManager();
			$LikesManager = new LikesManager();
			$CommentsManager = new CommentsManager();
			$all_imgs = $ImagesManager->select_all_id(FALSE, FALSE, "date_creation desc");
			$all_imgs = add_path_img($all_imgs);
			echo "<br /><br />All Images with Path :<br />";
			print_r($all_imgs);
			echo "<br /><br />LETS GO PUTS div MEDIA <br /><br />";
			$i = 1;
			foreach ($all_imgs as $key => $value) {
			
				$heart = "./resources/001-favorite.png";
				$action = "like_it";
				$user_id = $_SESSION['user_id'];
				$var = array('img_id' => $key, 'user_id' => $_SESSION['user_id']);
				if ($_SESSION['user_id'] != "unknown" && $LikesManager->is_already_in_bdd($var, 'AND') == TRUE) {
					$heart = "./resources/002-hearts.png";
					$action = "unlike_it";
				}
				$nb_likes = $LikesManager->count_id(TRUE, "img_id", $key);
				$nb_comments = $CommentsManager->count_id(TRUE, "img_id", $key);
				echo "nb_likes = " . $nb_likes;
				echo "nb_comments = " . $nb_comments;
				echo "<div class=media id=img_id$key><img src='$value'>
					<div class='nb_likes'>$nb_likes Like(s)</div>";
					if ($_SESSION['user_id'] !== 'unknown') {
						echo "<div class='add_like'>
						<a id='$action;$key;$user_id' href='#' onClick='loadMedia(this.id)'>
						<img src='$heart'></a>
						</div>
						<script src='./Controller/display.js'></script>";
					}
				echo "<div class='nb_comments'>$nb_comments Comment(s)</div>
					<div class='add_comment'></div>
					</div><br />";
			 };
		// 	handleImages($all_imgs);
		// </script>";
		?>
		</div>
    </div>
	<?php include("./View/footer.html"); ?>

</body>
</html>