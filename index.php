<?php	
	session_start();
?>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./View/style_css/style.css">
	<title>Camagru</title>
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


	<div id='gallery'> 
		<?php
			$ImagesManager = new ImagesManager();
			$all_imgs = $ImagesManager->select_all_id();

			$all_imgs = add_path_img($all_imgs);
			print_r($all_imgs);
		?>
		<script src=""></script>
	</div>
	<?php include("./View/footer.html"); ?>

</body>
</html>