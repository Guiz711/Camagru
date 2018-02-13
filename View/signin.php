<div id="popup_login_confirm" class="popup_login">
  
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
		Pour avoir un nouveau mail redonne nous ton login
		<div class="champ_signin">
			Nom d'utilisateur<input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
   <div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="confirm_mail"></div>
		<!-- <div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login_confirm').style.display='none'">Annuler</button></div> -->
    </div>
  </form>
</div>


<div id="popup_login_password_forgotten" class="popup_pwd_forgotten">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
  redonne ton login et/ou ton mail stp
		  <div class="champ_signin">Login <input type="text" placeholder="Login" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		  <div class="champ_signin">Adresse e-mail <input type="email" placeholder="Mail" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="mail"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="password_forgotten"></div>
		<!-- <div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login_confirm').style.display='none'">Annuler</button></div> -->
    </div>
  </form>
</div>

<div id='popup_reinitialize_password' class='popup_reinitialize_password'>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method='POST'>
	Il faut que tu indiques ton nouveau mot de passe
	<div class='champ_signin'>Nom d'utilisateur <input type='text' oninvalid='this.setCustomValidity('Merci de remplir ce champ.')' oninput='setCustomValidity('')' name='login'></div>
	<div class='champ_signin'>Mot de passe <input type='password' name='passwd'></div>
	<div class='champ_signin'>Mot de passe <input type='password' name='passwd2'></div>
	<div class='submit_button'><input type='submit'  name='submit_val' id='' value='reinitialize_passwd'></div>
	  </div>
	</form>
  </div>


<div id="popup_login" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
    <div class="formulaire">
		<div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		<div class="champ_signin">Mot de passe <input type="password" placeholder="Mot de passe" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="Connexion"></div>
		<div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login').style.display='none'">Annuler</button></div>
		<div class="submit_button"><button type="button" onclick="document.getElementById('popup_login_password_forgotten').style.display='block'" name="submit_val" id="pwd_forgotten" value="pwd_forgotten">Je suis trop bete j ai zappe mon mdp</button></div>
    </div>
  </form>
</div>

<script>


let button_password_forgotten = document.getElementById('pwd_forgotten');
button_password_forgotten.addEventListener('click', () => {
	let popup = document.getElementById('popup_login');
    popup.style.display = "none";
}, false);

</script>

<script>
	function	display_popup_reinitialize_password()
{
	let popup_reinitialize_password = document.getElementById('popup_reinitialize_password');
		popup_reinitialize_password.style.display = 'block';
}
		
</script>