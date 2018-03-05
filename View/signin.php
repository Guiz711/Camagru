<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
?>



<div id="popup_login_confirm" class="popup_login">
<div class="content_popup">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">Tu as pas encore confirmé ton inscription ! Pour avoir un nouveau mail, indique ton login. <br>
	<div class="champ_signin">Nom d'utilisateur<input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
	<div ><input class="submit_button" type="submit"  name="submit_val" value="Confirmer">
		  <button class="cancel_button" type="button" onclick="document.getElementById('popup_login_confirm').style.display='none'">Annuler</button></div>
  	</form>  
</div></div>


<div id="popup_login_password_forgotten" class="popup_login">
<div class="content_popup">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">Peux-tu indiquer ton login et/ou ton mail, s'il-te-plaît ? 
	<div class="champ_signin"><br>Login <input type="text" placeholder="Login" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
	<div class="champ_signin">Adresse e-mail <input type="mail" placeholder="Mail" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="mail"></div>
	<div><input class="submit_button" type="submit"  name="submit_val" value="Mot de passe oublié" >
		  <button class="cancel_button"type="button" onclick="document.getElementById('popup_login_password_forgotten').style.display='none'">Annuler</button></div>
	</form>
</div></div>

<div id='popup_reinitialize_password' class='popup_login'>
<div class="content_popup">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method='POST'>Il faut que tu indiques ton nouveau mot de passe
	<div class='champ_signin'>Nom d'utilisateur <input type='text' name='login'></div>
	<div class='champ_signin'>Mot de passe <input type='password' name='passwd'></div>
	<div class='champ_signin'>Mot de passe <input type='password' name='passwd2'></div>
	<div class='hidden'>Cle <input id='cle' type='text' name='forgot_passwd'></div>
	<div><input class='submit_button'type='submit'  name='submit_val' value='Réinitialiser mon mot de passe'>
		  <button class="cancel_button"type="button" onclick="document.getElementById('popup_reinitialize_password').style.display='none'">Annuler</button></div>
	</form>
</div></div>
	
<div id="popup_login" class="popup_login">
<div class="content_popup">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
	<div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
	<div class="champ_signin">Mot de passe <input type="password" placeholder="Mot de passe" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd"></div>
	<div><input class="submit_button" type="submit"  name="submit_val" value="Connexion">
		 <button type="button" class="cancel_button" onclick="document.getElementById('popup_login').style.display='none'">Annuler</button>
		 <button class="new_button" type="button" onclick="document.getElementById('popup_login_password_forgotten').style.display='block'; delete_popup('popup_login_password_forgotten');" name="submit_val" id="pwd_forgotten" value="pwd_forgotten">Mot de passe et/ou login oublié</button></div>
	</form>
</div></div>

<script>

let button_password_forgotten = document.getElementById('pwd_forgotten');
button_password_forgotten.addEventListener('click', () => {
	let popup = document.getElementById('popup_login');
    popup.style.display = "none";
}, false);
</script>

<script>
function	display_popup_reinitialize_password(forgot_passwd)
{
	let popup_reinitialize_password = document.getElementById('popup_reinitialize_password');
	let cle = document.getElementById('cle');
	cle.setAttribute("value", forgot_passwd);
	popup_reinitialize_password.style.display = 'block';
}		

function	display_popup_result(type)
{
	let popup_result = document.getElementById(type);
	popup_result.style.display = 'block';
}		

function delete_popup(type)
{
	let popup = document.getElementById(type);
		window.onclick = function(event) 
		{
		if (event.target == popup) {
			popup.style.display = 'none';
		}
	}
}
</script>