<?php

function signup_result($res)
{
	echo $res;
}

?>
<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
	<span>Login:<input type="text" name="login"></span>
	<span>Mot de Passe:<input type="text" name="passwd1"></span>
	<span>Confirmer Mot de Passe:<input type="text" name="passwd2"></span>
	<span>Mail:<input type="email" name="mail"></span>
	<input type="submit" name="submit_val" value="Inscription">
</form>