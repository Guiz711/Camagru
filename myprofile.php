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

    <header><?php
	    require("./requirements.php");
        include("./View/header_user.html");
        $UsersManager = new UsersManager();
        $res= $UsersManager->find_login_mail_notifications($_SESSION['user_id']);
    ?></header>

    <div class='hello'>Bonjour <?php echo $res[0]['u_login']; ?> !</div>
    
    <div class='me'>
        <div class='modify_myprofile'> <button id='login' href="#" onclick="document.getElementById('popup_modify').style.display='block', delete_popup('popup_modify')  " style="width:auto;">Modifier mes informations</button></div>
        <div class='modify_myprofile'> <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method='POST'>
        <?php
        $notifications= $res[0]['notifications'];
        if ($notifications == 1)
            echo "<input type='submit'  name='submit_val' value='Désactiver les notifications par mail'>";
        else
            echo "<input type='submit'  name='submit_val' value='Activer les notifications par mail'>";
        ?></form></div>
    </div>
    
    <div class="img_gallery">
        <div class="content" id="content_profile">
    <?php
            include("./Controller/displayMedia.php");
            display_myprofile();
    ?>
        </div>
    </div>
    <script src='./Controller/thumbnails.js'></script> 

</body>
<footer>     <?php include("./View/footer.html"); ?></footer>
</html>



