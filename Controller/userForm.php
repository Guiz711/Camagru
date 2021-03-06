<?php

if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function  sendMailComment($img_id){
	$ImagesManager = new ImagesManager();
	$UsersManager = new UsersManager();

	$folder = getcwd();
	$folder = explode('/', $folder);
    $user_id = $ImagesManager->find_userid($img_id);
    $user_id =  $user_id[0]['user_id'];
    $res= $UsersManager->find_login_mail_notifications($user_id);
    $login = $res[0]['u_login'];
    $mail = $res[0]['mail'];
    $subject = "Vous avez recu un commentaire sur une de vos photos" ;
	$from_who = "From: notification@camagru.com" ;
	$message = 'Vous avez eu un nouveau commentaire sur votre image
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
}

function is_valid_passwd($passwd)
{
	$pattern = '/([0-9]+.*[A-Z]+)|([A-Z]+.*[0-9]+)/';
	if (!preg_match($pattern, $passwd))
		return (false);
	return (true);
}

function user_signup($login, $passwd1, $passwd2, $mail)
{
	$user = new UsersManager();

	if (strlen($login) < LOGIN_LEN)
		return ("Votre login est trop court.");
	if (strlen($passwd1) < PASSWD_LEN)
		return ("Votre mot de passe est trop court, il doit faire au moins " . PASSWD_LEN . " caractères.");
	if (!is_valid_passwd($passwd1))
		return ("Votre mot de passe doit contenir au moins une majuscule et un chiffre");
	if ($passwd1 !== $passwd2)
		return ("Attention, les deux mots de passe ne sont pas pareils");
	$passwd = password_hash($passwd1, PASSWORD_DEFAULT);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "OR", NULL)) {
		return ("Le login ou l'adresse mail que vous tentez d'utiliser existent déjà.");
	}
	$cle = md5(microtime(TRUE)*100000);       // cle aleatoire
	$user->insert(array(
			'u_login' => $login,
			'passwd' => $passwd,
			'mail' => $mail,
			'cle' => $cle
		));
	$folder = getcwd();
	$folder = explode('/', $folder);
	$folder = $folder[count($folder) - 1];
	$subject = "Activez votre compte" ;
	$from_who = "From: inscription@camagru.com" ;
	$message = '
	Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who) ;
	$res = 'Inscription à confirmer, tu dois aller voir tes mails et valider</br>';
	return ($res);
}

function user_signin($login, $passwd)
{
	$user = new UsersManager();

	if (!($res = $user->auth($login)) || !password_verify($passwd, $res[0]['passwd'])) {
		return "Connexion échouée, mauvais login ou mot de passe.</br>";
	}
	if ($res[0]['actif'] == 0){
		return array("msg" => "Tu as pas encore confirmé ton inscription ! </br>", "login" => $login, "cle" => $res[0]['cle'], "mail" => $res[0]['mail']);
	}
	$_SESSION['user_id'] = $res[0]['user_id'];
	return "Connexion réussie!</br>";
}

function user_confirm_mail($login)
{
	$user = new UsersManager();
	$res = $user->auth($login);
	if (empty($res))
		return ("Erreur");
	$cle = $res[0]['cle'];
	$mail = $res[0]['mail'];
	$subject = "Activez votre compte" ;
	$from_who = "From: inscription@camagru.com" ;
	$folder = getcwd();
	$folder = explode('/', $folder);
	$folder = $folder[count($folder) - 1];
	$message = '
	Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return ("Le mail de confirmation a bien été envoyé</br>");
}

function user_change_mail($id, $login, $newmail)
{
	$user = new UsersManager();
	$res = $user->auth($login);
	if (empty($res))
		return ("Erreur");
	$cle = md5(microtime(TRUE)*100000);
	$user->user_modify($id, "cle", $cle);  
	$subject = "Changez votre mail" ;
	$from_who = "From: inscription@camagru.com" ;
	$folder = getcwd();
	$folder = explode('/', $folder);
	$folder = $folder[count($folder) - 1];
	$message = '
	Pour que cette nouvelle adresse mail soit bien prise en compte clique là :
	http://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/index.php?login='.urlencode($login).'&clemail='.urlencode($cle).'
	------------- With <3';
	mail($newmail, $subject, $message, $from_who);
	return ("Le mail de changement a bien été envoyé</br>");
}

function user_password_forgotten($login, $mail)
{
	$user = new UsersManager();
	if(empty($login) && empty($mail))
		return ("Les champs doivent être remplis");
	else if(!empty($login) && !empty($mail)){
		$result = $user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "AND", NULL);
		if ($result == FALSE)
			return ("Les champs remplis ne sont pas exacts");
	}
	else if(!empty($login) && empty($mail)){
		$res = $user->auth($login);
		$mail = $res[0]['mail'];
		if ($mail == "")
			return ("Le champ rempli n'est pas exact");
	}
	else if(empty($login) && !empty($mail)){
		$result = $user->select_all(array('mail' => $mail), FALSE, FALSE);
		$login = $result[0]['u_login'];
		if ($login == "")
			return ("Le champ rempli n'est pas exact");
	}
	$subject = "Réinitialiser votre mot de passe" ;
	$from_who = "From: password@camagru.com" ;
	$forgot_passwd = md5(microtime(TRUE)*100000);
	$user->forgot_passwd($login, $forgot_passwd, $mail);
	$folder = getcwd();
	$folder = explode('/', $folder);
	$folder = $folder[count($folder) - 1];
	$message = '
	Bonjour '.$login.', clique sur le lien suivant pour réinitialiser ton mot de passe :
	http://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/index.php?login='.urlencode($login).'&forgot_passwd='.urlencode($forgot_passwd).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return ("Mail envoyé");
}

function user_reinitialize_passwd($login, $passwd, $passwd2, $forgot_passwd)
{
	$user = new UsersManager();
	if ($user->is_already_in_bdd(array('u_login' => $login, 'forgot_passwd' => $forgot_passwd), "AND", NULL)){ 
		if ($passwd != $passwd2 || strlen($passwd) < PASSWD_LEN)
			return ("Les mots de passe sont trop courts (minimum " . PASSWD_LEN . " caractères) et/ou ne sont pas identiques</br>");
		else
		{
			$passwd = password_hash($passwd, PASSWORD_DEFAULT);
			$user->change_passwd($passwd, $login);
			$forgot_passwd = md5(microtime(TRUE)*100000);
			$user->forgot_passwd($login, $forgot_passwd, FALSE);
			return ("Ton mot de passe a bien été modifié </br>");
		}
	}
	else {
		return("Erreur");
	}
}

function user_modify($newlogin, $newpasswd, $newpasswd2, $newmail, $passwd)
{
	$user = new UsersManager();
	$id = $_SESSION['user_id'];
	$find_login = $user->find_login($id);
	$login = $find_login[0]['u_login'];
	$mail= $find_login[0]['mail'];
	$res = $user->auth($login);
	$message = "</br>";
	if (!password_verify($passwd, $res[0]['passwd'])) {
		return "Le mot de passe entré est erroné</br>";
	}
	if ($newmail == "" && $newpasswd == "" && $newlogin == ""){
		return "Tu dois modifier au moins ton login, ton mail ou ton mot de passe</br>";
	}
	if ($newmail != "" && $newmail == $res[0]['mail']) {
		return "Tu as déjà ce mail</br>";	
	}
	if ($login == $newlogin)
	{
		return("Merci de changer de login</br>");
	}
	if ($user->is_already_in_bdd(array('u_login' => $newlogin, 'mail' => $newmail), "OR", NULL)){
		return "Ce login ou ce mail existe déjà</br>";
	}
	if ($newpasswd == $passwd) {
		return "Merci d'entrer un nouveau mot de passe</br>";
	}
	if ($newpasswd != $newpasswd2) {
		return "Merci d'entrer deux mots de passe identiques</br>";
	}
	if ($newpasswd != "" && strlen($newpasswd) < PASSWD_LEN) {
		return "Merci d'entrer un mot de passe plus long</br>";
	}
	if ($newlogin != ""){
		$user->user_modify($id, "u_login", $newlogin);
		$login = $newlogin;
	}
	if ($newpasswd != "" && !is_valid_passwd($newpasswd))
		return ("Votre mot de passe doit contenir au moins une majuscule et un chiffre</br>");
	if ($newpasswd != "")
		$user->user_modify($id, "passwd", password_hash($newpasswd, PASSWORD_DEFAULT));
	if ($newmail != "")
	{
		user_change_mail($id, $login, $newmail);
		$message = " sauf ta nouvelle adresse mail que tu dois confirmer (va voir ta boîte de réception).</br>";
		$user->user_modify($id, "tmp", $newmail);
		// $mail = $newmail;
	}
	// $subject = "Changement de tes informations personnelles" ;
	// $from_who = "From: mail@camagru.com" ;
	// $message = 'Bonjour '.$login.', une ou plusieurs de tes informations personnelles viennent d\'être modifiées. Si ce n\'est pas toi, alors qqn a ton mot de passe. contacte-nous <3';
	// mail($mail, $subject, $message, $from_who);
	return ("Tes informations ont bien été modifiées".$message);
}
function user_modify_preferences()
{
	$user = new UsersManager();
	$id = $_SESSION['user_id'];
	$res = $user->find_login_mail_notifications($id);
	if ($res[0]['notifications'] == 0)
		$user->user_modify($id, 'notifications', 1);
	else if ($res[0]['notifications'] == 1)
		$user->user_modify($id, 'notifications', 0);
	return ("Tes préférences ont bien été modifiées </br>");
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
	if ($_POST['submit_val'] == 'Confirmer') {
		$res = user_confirm_mail(sanitize_input($_POST['login']));
		display_result_userform($res, 'confirm_mail');
	}
	if ($_POST['submit_val'] == "Mot de passe oublié") {
		$res = user_password_forgotten(sanitize_input($_POST['login']), 
			sanitize_input($_POST['mail']));
		display_result_userform($res, 'password_forgotten');
	}
	if ($_POST['submit_val'] == 'Réinitialiser mon mot de passe') {
		$res = user_reinitialize_passwd(sanitize_input($_POST['login']), 
			sanitize_input($_POST['passwd']), sanitize_input($_POST['passwd2']), sanitize_input($_POST['forgot_passwd']));
		display_result_userform($res, 'reinitialize_passwd');
	}
	if ($_POST['submit_val'] == 'Modifier mon compte') {
			$res = user_modify(sanitize_input($_POST['newlogin']), 
			sanitize_input($_POST['newpasswd']), sanitize_input($_POST['newpasswd2']), sanitize_input($_POST['newmail']), 
			sanitize_input($_POST['passwd']));
		display_result_userform($res, 'modify');
	}
	if ($_POST['submit_val'] == 'Désactiver les notifications par mail' || $_POST['submit_val'] == 'Activer les notifications par mail') {
		$res = user_modify_preferences();
		display_result_userform($res, 'modify_preferences');
}
}
else if (isset($_GET['login']) && isset($_GET['cle']))
{
	$login = sanitize_input($_GET['login']);
	$cle = sanitize_input($_GET['cle']);
	$user->confirm_inscription($login, $cle);
}

else if (isset($_GET['login']) && isset($_GET['clemail']))
{
	$login = sanitize_input($_GET['login']);
	$cle = sanitize_input($_GET['clemail']);
	$res = $user->auth($login);
	$mail = $res[0]['tmp'];
	if ($cle == $res[0]['cle']) {
		$id = $res[0]['user_id'];
		$user->user_modify($id, "mail", $mail);
		display_result_userform("Voici ta nouvelle adresse mail : $mail", 'modify');
	}
	else {
		display_result_userform("Nous n'avons pas pu changer ton adresse mail", 'modify');
	}
}

else if (isset($_GET['login']) && isset($_GET['forgot_passwd']))
{
	$login = sanitize_input($_GET['login']);
	$forgot_passwd = sanitize_input($_GET['forgot_passwd']);
	if ($user->is_already_in_bdd(array('u_login' => $login, 'forgot_passwd' => $forgot_passwd), "AND", NULL)) 
		$res = "script";		
	else
		$res = "Lien erroné";
		display_reinitialize_passwd($res, 'get_reinitialize_passwd', $forgot_passwd);
}
?>
