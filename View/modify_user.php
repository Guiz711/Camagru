<div id='popup_modify' class='popup_login'>
        <div class='content_popup'>
        <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?> method='POST'>
         Merci de compléter les champs que vous souhaitez modifier
              <div class='champ_signin'>Nouveau nom d'utilisateur <input type='text' placeholder='Nom utilisateur' name='newlogin'></div>
              <div class='champ_signin'>Nouveau mot de passe <input type='password' placeholder='Mot de passe' name='newpasswd'></div>
              <div class='champ_signin'>Confirme ton nouveau mot de passe <input type='password' placeholder='Mot de passe' name='newpasswd2'></div>
              <div class='champ_signin'>Nouveau mail <input type='mail' placeholder='mail' name='newmail'></div>
              <div class='champ_signin'>Avant de valider, vous devez redonner votre mot de passe actuel (obligatoire) <input type='password' placeholder='Mot de passe' required oninvalid='this.setCustomValidity('Merci de remplir ce champ.')' oninput='setCustomValidity('')' name='passwd'></div>
              <div class='submit_button'><input type='submit'  name='submit_val' value='modify_user'></div>
              <div class='cancel_button'><button type='button' onclick="document.getElementById('popup_modify').style.display='none'">Annuler</button></div>
        </form>
      </div>
</div>


<script>
delete_popup('popup_modify');
</script>


