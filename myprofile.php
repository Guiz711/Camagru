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
    ?></header>

    <div> 
    <a id="login" href="#" onclick="document.getElementById('popup_modify').style.display='block'" style="width:auto;">Modifier mes informations</a></div>
    </div>
      
   
	
</body>
<footer>     <?php include("./View/footer.html"); ?></footer>

<script>
</script>

</html>
