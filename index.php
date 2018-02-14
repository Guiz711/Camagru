<?php	
	session_start();
	// print_r($_SESSION);
	if (!array_key_exists('user_id', $_SESSION))
		$_SESSION['user_id'] = "unknown";


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
        <div class="content">
		<?php
			include("./Controller/displayMedia.php");
			display_index();
		?>
		</div>
    </div>
	<?php include("./View/footer.html"); ?>
	<script src='./Controller/thumbnails.js'></script>
</body>
</html>