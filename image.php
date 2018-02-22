<?php	
	session_start();
	//print_r($_SESSION);
	if (!array_key_exists('user_id', $_SESSION))
		$_SESSION['user_id'] = "unknown";
	if ($_SESSION && array_key_exists('display_id', $_SESSION))
        unset($_SESSION['display_id']);
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
	require("./requirements.php");
	if ($_SESSION["user_id"] !== "unknown")
		include("./View/header_user.html");
	else
		include("./View/header_visitor.html");
	?>

	</header>
	<div class="img_gallery">
        <div class="content" id="content_index">
		<?php
			include("./Controller/displayOneMedia.php");
			display_index($_post);
		?>
		</div>
    </div>
	<footer>   <?php include("./View/footer.html"); ?> </footer>
	<script src='./Controller/thumbnails.js'></script>
</body>
</html>