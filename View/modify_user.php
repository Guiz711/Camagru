<div id="popup_modify" class="popup_login">
        
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
         Merci de compléter les champs que vous souhaitez modifier
              <div class="champ_signin">Nouveau nom d'utilisateur <input type="text" placeholder="Nom d'utilisateur" name="newlogin"></div>
              <div class="champ_signin">Nouveau mot de passe <input type="password" placeholder="Mot de passe" name="newpasswd"></div>
              <div class="champ_signin">Nouveau mail <input type="mail" placeholder="mail" name="newmail"></div>
              <div class="champ_signin">Avant de valider, vous devez redonner votre mot de passe actuel <input type="password" placeholder="Mot de passe" required oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="passwd"></div>
              <div class="submit_button"><input type="submit"  name="submit_val" id="" value="modify_user"></div>
              <div class="cancel_button"><button type="button" onclick="document.getElementById('popup_modify').style.display='none'">Annuler</button></div>

        </form>
</div>
<!-- <div id="popup_modify" class="popup_login">
  
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
  redonne ton login et/ou ton mail stp
		  <div class="champ_signin">Login <input type="text" placeholder="Login" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="login"></div>
		  <div class="champ_signin">Adresse e-mail <input type="email" placeholder="Mail" oninvalid="this.setCustomValidity('Merci de remplir ce champ.')" oninput="setCustomValidity('')" name="mail"></div>
		<div class="submit_button"><input type="submit"  name="submit_val" id="button_signin" value="modify_user"></div>
	
    </div>
  </form>
</div> -->
<script>
delete_popup('popup_modify')
</script>
