<!DOCTYPE html>
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
		session_start();
		require_once("./requirements.php");
		?>
	</header>

	<div id='gallery'>
		<?php 
			$ImagesManager = new ImagesManager();
			$all_imgs = $ImagesManager->select_all_id();
			$all_imgs = add_path_img($all_imgs);
		?>
		<script src="">

		</script>
		</div>
	</div>
	<footer>

	</footer>

</body>
</html>