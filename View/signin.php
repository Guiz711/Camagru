<?php

function signin_result($res)
{
	if (empty($res))
		echo "Connexion Reussie!</br>";
	else
		echo $res;
}

?>
<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="POST">
	<span>Login:<input type="text" name="login"></span>
	<span>Mot de Passe:<input type="text" name="passwd"></span>
	<input type="submit" name="submit" value="Connexion">
</form>