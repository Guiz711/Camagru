<?php
//include_once("../Model/UsersManager.class.php");

function is_valid_passwd($passwd)
{
	$pattern = '/([0-9]+.*[A-Z]+)|([A-Z]+.*[0-9]+)/';
}

function user_signup($login, $passwd1, $passwd2, $mail)
{
	$user = new UsersManager();
	if (strlen($login) < LOGIN_LEN)
		return "SignUP FAILED : Login too short</br >";
	if (strlen($passwd1) < PASSWD_LEN)
		return "SignUP FAILED : Password too short</br >";
	if ($passwd1 !== $passwd2)
		return "SignUP FAILED : Password confirmation different</br >";
	$passwd = password_hash($passwd1, PASSWORD_DEFAULT);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "OR", NULL)) {
		echo "SignUP FAILED : Login or mail already exists </br >";
		return (FALSE);
	}
	$user->insert(array(
			'u_login' => $login,
			'passwd' => $passwd,
			'mail' => $mail
		));
	return "Inscription Réussie!</br>";
}

function user_signin($login, $passwd)
{
	$user = new UsersManager();

	if (!($res = $user->auth($login, $passwd)) || !password_verify($passwd, $res[0]['passwd'])) {
		return "Connexion Echouee, Mauvais login ou mot de passe.</br>";
	}
	$_SESSION['user_id'] = $res[0]['user_id'];
	return "Connexion Reussie!</br>";
}
// echo "hello!</br>";
// print_r($_POST);
if (array_key_exists('submit_val', $_POST)) {	
	// echo $_POST['submit_val'], '</br>';
	if ($_POST['submit_val'] == 'Inscription') {
		$res = user_signup(sanitize_input($_POST['login']), sanitize_input($_POST['passwd1']),
		sanitize_input($_POST['passwd2']), sanitize_input($_POST['mail']));
		signup_result($res);
	}
	if ($_POST['submit_val'] == 'Connexion') {
		// echo 'Cooooooneeeeeexion...</br>';
		$res = user_signin(sanitize_input($_POST['login']), sanitize_input($_POST['passwd']));
		// signin_result($res);
	}
	if ($_POST['submit_val'] == 'disconnect') {
		$_SESSION['user_id'] = 'unknown';
		echo $_SESSION['user_id'];
	}
}
// echo $_SESSION['user_id'];

?>