<?php	
session_start();
$vault = true;
if (!array_key_exists('user_id', $_SESSION))
	$_SESSION['user_id'] = "unknown";
if ($_SESSION['user_id'] === "unknown")
{
	header('location: index.php');
	die();
}
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
    include("./View/header_user.html");
    include("./Controller/displayMedia.php");
    ?>
	</header>
    
    <div class="corpus">
        <div class="webcam">
            <div id="webcam_content">
                <video id='video'></video>
                <canvas id='canvas'></canvas>
                <img src='#' class='hidden' id='photo'> 
            </div>
            
            <div><button id='startbutton'>Prendre une photo</button></div>
            <div><input class='hidden' id='Description' type="text" name="description">Description</input></div>
            <div><button class='hidden' id='savebutton'>Enregistrer la photo</button></div>
            <div><button class='hidden' id='cancel_photomontage'>Annuler</button></div>
            <div><input type="file" id="choose_img" name="choose_img" accept=".jpg, .jpeg, .png"> </div>
            
            <div class="filters">   <?php  display_filters();  ?>   </div>
        
        </div>

        <div class="photo_media">
			<div class="title_photo_media">Tes trois derniers photomontages</div>
			<?php   display_photomontage(); ?>
		</div>

    </div>
    
    
    
    <?php include("./View/footer.html"); ?>

    <script src='./Controller/thumbnails.js'></script>
    <script src='./Controller/photomontage.js'></script>
</body>
</html>