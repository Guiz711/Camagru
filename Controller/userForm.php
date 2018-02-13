<?php

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
	$cle = md5(microtime(TRUE)*100000);       // cle aleatoire
	$user->insert(array(
			'u_login' => $login,
			'passwd' => $passwd,
			'mail' => $mail,
			'cle' => $cle
		));
	$subject = "Activez votre compte" ;
	$from_who = "From: inscription@camagru.com" ;
	$message = 'Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://localhost:8080//camagru_project/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who) ;
	return "Inscription à confirmer, tu dois aller voir tes mails et valider";
}

function user_signin($login, $passwd)
{
	$user = new UsersManager();

	if (!($res = $user->auth($login)) || !password_verify($passwd, $res[0]['passwd'])) {
		return "Connexion échouée, mauvais login ou mot de passe.</br>";
	}
	if ($res[0]['actif'] == 0)
	{
		return array("msg" => "Tu as pas encore confirmé ton inscription ! Crétin des alpes ! </br>", "login" => $login, "cle" => $res[0]['cle'], "mail" => $res[0]['mail']);
	}
	$_SESSION['user_id'] = $res[0]['user_id'];
	return "Connexion réussie!</br>";
}

function user_confirm_mail($login)
{
	$user = new UsersManager();
	$res = $user->auth($login);
	if (empty($res))
		return (false);
	$cle = $res[0]['cle'];
	$mail = $res[0]['mail'];
	$subject = "Activez votre compte" ;
	$from_who = "From: inscription@camagru.com" ;
	$message = 'Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://localhost:8080//camagru_project/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return (true);
}

function user_password_forgotten($login, $mail)
{
	$user = new UsersManager();
	if(empty($login) && empty($mail))
		return ("empty_fields");
	else if(!empty($login) && !empty($mail))
	{
		$result = $user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "AND", NULL);
		if ($result == FALSE)
			return ("wrong_params");
	}
	else if(!empty($login) && empty($mail))
	{
		$res = $user->auth($login);
		$mail = $res[0]['mail'];
		if ($mail == "")
			return ("wrong_params");
	}
	else if(empty($login) && !empty($mail))
	{
		$result = $user->select_all(array('mail' => $mail), FALSE, FALSE);
		$login = $result[0]['u_login'];
		if ($login == "")
			return ("wrong_params");
	}
	$subject = "Reinitialiser votre mot de passe" ;
	$from_who = "From: password@camagru.com" ;
	$forgot_passwd = md5(microtime(TRUE)*100000);
	$user->forgot_passwd($login, $forgot_passwd, $mail);
	$message = 'Bonjour '.$login.', clique la pour reinitialiser ton mot de passe :
	http://localhost:8080//camagru_project/index.php?login='.urlencode($login).'&forgot_passwd='.urlencode($forgot_passwd).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return ("mail_sent");
}

function user_reinitialize_passwd($login, $passwd, $passwd2)
{
	$user = new UsersManager();
	if ($passwd != $passwd2)
		return ("wrong_params");
	else
	{
		$passwd = password_hash($passwd, PASSWORD_DEFAULT);
		$user->change_passwd($passwd, $login);
		$forgot_passwd = md5(microtime(TRUE)*100000);
		$user->forgot_passwd($login, $forgot_passwd, FALSE);
		return ("params_changed");
	}

}

$user = new UsersManager();
if (array_key_exists('submit_val', $_POST)) {	
	if ($_POST['submit_val'] == 'Inscription') {
		$res = user_signup(sanitize_input($_POST['login']), sanitize_input($_POST['passwd1']),
		sanitize_input($_POST['passwd2']), sanitize_input($_POST['mail']));
		signup_result($res);
	}
	if ($_POST['submit_val'] == 'Connexion') {
		$res = user_signin(sanitize_input($_POST['login']), sanitize_input($_POST['passwd']));
		signin_result($res);
	}
	if ($_POST['submit_val'] == 'disconnect') {
		$_SESSION['user_id'] = 'unknown';
	}
	if ($_POST['submit_val'] == 'confirm_mail') {
		$res = user_confirm_mail(sanitize_input($_POST['login']));
		display_result_userform($res, 'confirm_mail');
	}
	if ($_POST['submit_val'] == 'password_forgotten') {
		$res = user_password_forgotten(sanitize_input($_POST['login']), 
			sanitize_input($_POST['mail']));
		display_result_userform($res, 'password_forgotten');
	}
	if ($_POST['submit_val'] == 'reinitialize_passwd') {
		$res = user_reinitialize_passwd(sanitize_input($_POST['login']), 
			sanitize_input($_POST['passwd']), sanitize_input($_POST['passwd2']));
		display_result_userform($res, 'reinitialize_passwd');
	}
}
else if (isset($_GET['login']) && isset($_GET['cle']))
{
	$login = sanitize_input($_GET['login']);
	$cle = sanitize_input($_GET['cle']);
	$user->confirm_inscription($login, $cle);
}
else if (isset($_GET['login']) && isset($_GET['forgot_passwd']))
{
	$login = sanitize_input($_GET['login']);
	$forgot_passwd = sanitize_input($_GET['forgot_passwd']);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'forgot_passwd' => $forgot_passwd), "AND", NULL)) 
		$res = "script";		
	else
		$res = "wrong_params";
	display_result_userform($res, 'get_reinitialize_passwd');
}
?>
