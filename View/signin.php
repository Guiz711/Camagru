<?php


function signin_result($res)
{
	if (is_array($res))
	{
		echo $res['msg'];
		$test = "document.getElementById('popup_login_confirm').style.display='block'";
		echo "<div><a href='#' onclick=$test style='width:auto;'>Renvoyer autre mail</a></div>";
	}
	else
		echo $res;
}

// function password_forgotten()
// {
// 	$value = "document.getElementById('popup_login_password_forgotten').style.display='block'";
// 	echo "<div><a href='#' onclick=$value style='width:auto;'>Donne ton mail</a></div>";
// }


?>
<div id="popup_login_confirm" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
   Pour avoir un nouveau mail redonne nous ton login
   <div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
   <div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="confirm_mail"></div>
		<!-- <div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login_confirm').style.display='none'">Annuler</button></div> -->
    </div>
  </form>
</div>



<div id="popup_login_password_forgotten" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
  		<div class="champ_signin">Adresse e-mail <input type="email" placeholder="Mail" required="" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="mail"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="password_forgotten"></div>
		<!-- <div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login_confirm').style.display='none'">Annuler</button></div> -->
    </div>
  </form>
</div>

<!-- $value = "document.getElementById('popup_login_password_forgotten').style.display='block'";
	echo "<div><a href='#' onclick=$value style='width:auto;'>Donne ton mail</a></div>"; -->


<div id="popup_login" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
    <div class="formulaire">
		<div class="champ_signin">Nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		<div class="champ_signin">Mot de passe <input type="password" placeholder="Mot de passe" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="Connexion"></div>
		<div class="cancel_button"><button type="button" onclick="document.getElementById('popup_login').style.display='none'">Annuler</button></div>
		<div class="submit_button"><input type="submit" onclick="document.getElementById('popup_login_password_forgotten').style.display='block'" name="submit_val" id="pwd_forgotten" value="pwd_forgotten"></div>
    </div>
  </form>
</div>

