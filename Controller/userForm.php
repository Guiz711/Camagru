<?php

$LOGIN_LEN = 3;
$PASSWD_LEN = 8;

include_once("$SITE_PATH/Model/UsersManager.class.php");

function user_signup($login, $passwd, $mail)
{
	$user = new UsersManager();
	echo 'test1.1</br>';
	// if (strlen($login) < $LOGIN_LEN)
	// 	return ('Login too short');
	// if (strlen($passwd) < $PASSWD_LEN)
	// 	return ('Password too short');
	$passwd = hash('whirlpool', $passwd);
	echo $user;
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $email), "OR", NULL))
		return ('Login or email already exists');
	$user->insert(array(
			'u_login' => $login,
			'passwd' => $passwd,
			'mail' => $mail
		), null);
	echo 'test3</br>';
}

print_r($_POST);
echo '</br>';
if (array_key_exists('submit', $_POST)) {	
	if ($_POST['submit'] == 'Inscription') {
		user_signup(sanitize_input($_POST['login']),
			sanitize_input($_POST['passwd']), sanitize_input($_POST['mail']));
	}
}

?>