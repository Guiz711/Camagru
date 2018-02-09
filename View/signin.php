<?php

function signin_result($res)
{
	if (is_array($res))
	{
		echo $res['msg'];
		echo "puisqu on est gentils on t'en renvoie un";
		$login = $res['login'];
		$cle = $res['cle'];
		$mail = $res['mail'];
		$subject = "Activez votre compte" ;
		$from_who = "From: inscription@camagru.com" ;
		$message = 'Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
		http://localhost:8080//camagru_project/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
		------------- With <3';
		mail($mail, $subject, $message, $from_who);
	}

	else
		echo $res;
}

?>


<div id="popup_login" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
    <div class="formulaire">
		<div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		<div class="champ_signin">Mot de passe <input type="password" placeholder="Mot de passe" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="Connexion"></div>
		<div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login').style.display='none'">Annuler</button></div>
    </div>
  </form>
</div>

