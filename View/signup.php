<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
?>

<div id="popup_signup" class="popup_login">
<div class="content_popup">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
		<div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		<div class="champ_signin">Mot de passe <input type="password" placeholder="Mot de passe" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd1"></div>
		<div class="champ_signin">Confirmer le mot de passe <input type="password" placeholder="Mot de passe" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd2"></div>
		<div class="champ_signin">Adresse e-mail <input type="mail" placeholder="Mail" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="mail"></div>
		<div ><input class="submit_button"type="submit"  name="submit_val" id="button_signup" value="Inscription">
		<button class="cancel_button" type="button" onclick="document.getElementById('popup_signup').style.display='none'">Annuler</button></div>
	</form>
	</div>
</div>
