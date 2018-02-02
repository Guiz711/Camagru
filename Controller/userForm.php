<?php

$LOGIN_LEN = 3;
$PASSWD_LEN = 8;

include_once("../Model/UsersManager.class.php");

function user_signup($login, $passwd, $mail, $dbRootInfo)
{
<<<<<<< HEAD
	$user = new UsersManager();
	if (strlen($login) < $LOGIN_LEN) {
		echo "SignUP FAILED : Login too short </br >";
		return (FALSE);
	}
	if (strlen($passwd) < $PASSWD_LEN) {
		echo "SignUP FAILED : Password too short </br >";
		return (FALSE);
	}
	$passwd = hash('whirlpool', $passwd);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "OR", NULL)) {
		echo "SignUP FAILED : Login or mail already exists </br >";
		return (FALSE);
	}
=======
	$user = new UsersManager($dbRootInfo);
	echo 'test1.1</br>';
	// if (strlen($login) < $LOGIN_LEN)
	// 	return ('Login too short');
	// if (strlen($passwd) < $PASSWD_LEN)
	// 	return ('Password too short');
	$passwd = hash('whirlpool', $passwd);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "OR", NULL))
		return ('Login or email already exists');
>>>>>>> 9ebd6f71212e233acf5b4279ce0135720ab03256
	$user->insert(array(
			'u_login' => $login,
			'passwd' => $passwd,
			'mail' => $mail
		), null);
}

if (array_key_exists('submit', $_POST)) {	
	if ($_POST['submit'] == 'Inscription') {
		user_signup(sanitize_input($_POST['login']),
			sanitize_input($_POST['passwd']), sanitize_input($_POST['mail']), $dbRootInfo);
	}
}

?>