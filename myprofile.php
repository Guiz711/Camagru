<?php	
session_start();
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
<header><?php
	require("./requirements.php");
    include("./View/header_user.html");
    $UsersManager = new UsersManager();
    $res= $UsersManager->find_login_mail_notifications($_SESSION['user_id']);
    ?></header>

    <div class='me'>
        <div class='modify_myprofile'> <a id='login' href="#" onclick="document.getElementById('popup_modify').style.display='block'" style="width:auto;";>Modifier mes informations</a></div>
        <div class='modify_myprofile'><a> Notifications par mail :</a> <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method='POST'>
        <?php
        $notifications= $res[0]['notifications'];
        if ($notifications == 1)
            echo "<div class='submit_button'><input type='submit'  name='submit_val' value='Désactiver'</div>";
        else
            echo "<div class='submit_button'><input type='submit'  name='submit_val' value='Activer'></div>";
        ?></form></div>
    </div></div>
    
    <div class="img_gallery">
        <div class="content" id="content_index">
    <?php
            include("./Controller/displayMedia.php");
            display_myprofile();
    ?>
        </div>
    </div>
	<script src='./Controller/thumbnails.js'></script>
    

   
	
</body>
<footer>     <?php include("./View/footer.html"); ?></footer>

<script>
</script>

</html>



