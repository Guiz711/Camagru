<?php

function signin_result($res)
{
	echo $res;
}

?>
<div id="login_form" class="hidden">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
		<span>Login:<input type="text" name="login"></span>
		<span>Mot de Passe:<input type="text" name="passwd"></span>
		<input type="submit" name="submit" value="Connexion">
	</form>
</div>