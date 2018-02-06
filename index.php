<?php	
	session_start();
	if (!array_key_exists('user_id'))
		$_SESSION['user_id'] = "Unknown";
?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./View/style_css/style.css">
	<title>Camagru</title>
	<meta charset="UTF-8">
</head>
<body>

	<header>

	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
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
			$all_imgs = $ImagesManager->select_all_id("DESC");

			$all_imgs = add_path_img($all_imgs);
			print_r($all_imgs);
			echo "<br />";
			foreach ($all_imgs as $key => $value) {
				$heart = "./resources/001-favorite.png";
				$var = array('img_id' => $key, 'user_id' => $_SESSION['user_id']);
				if ($_SESSION['user_id'] != "" && $LikesManager->is_already_in_bdd($var, 'AND') == TRUE)
					$heart = "./resources/002-hearts.png";
				$nb_likes = $LikesManager->count_id(TRUE, "img_id", $key);
				echo "nb_likes = " . $nb_likes;
				echo "<div class=media><img src='$value'>
					<div class='likes'><a href='#'></div>
					<div class='add_like'><img src='$heart'</a></div>
					<div class='comments'></div>
					<div class='add_comment'></div>
					</div>";
			 };
		// 	handleImages($all_imgs);
		// </script>";
		?>
		</div>
    </div>
	<?php include("./View/footer.html"); ?>

</body>
</html>