<?php

// function signin_result($res)
// {
// 	echo $res;
// }

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

