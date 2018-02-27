<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function  sendMailComment($img_id){
	$folder = getcwd();
	$folder = explode('/', $folder);
	// echo $folder[count($folder) - 2];
    $ImagesManager = new ImagesManager();
    $user_id = $ImagesManager->find_userid($img_id);
    $user_id =  $user_id[0]['user_id'];
    $UsersManager = new UsersManager();
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
		return ("Votre mot de passe est trop court.");
	if (!is_valid_passwd($passwd1))
		return ("Votre mot de passe doit contenir au moins une majuscule et un chiffre");
	if ($passwd1 !== $passwd2)
		return ("Attention, les deux mots de passe ne sont pas pareils");
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
	$folder = getcwd();
	$folder = explode('/', $folder);
	$folder = $folder[count($folder) - 1];
	$subject = "Activez votre compte" ;
	$from_who = "From: inscription@camagru.com" ;
	$message = 'Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://localhost:8080//'.$folder.'/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who) ;
	$res = 'Inscription à confirmer, tu dois aller voir tes mails et valider';
	return ($res);
}

function user_signin($login, $passwd)
{
	$user = new UsersManager();

	if (!($res = $user->auth($login)) || !password_verify($passwd, $res[0]['passwd'])) {
		return "Connexion échouée, mauvais login ou mot de passe.</br>";
	}
	if ($res[0]['actif'] == 0)
	{
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
	$message = 'Bienvenue sur le meilleur site dédié aux cookies (les seules autres photos autorisées sont celles de Norminet). Si tu veux toujours participer, active ton compte en cliquant là :
	http://localhost:8080//'.$folder.'/index.php?login='.urlencode($login).'&cle='.urlencode($cle).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return ("Le mail de confirmation a bien été envoyé");
}

function user_password_forgotten($login, $mail)
{
	$user = new UsersManager();
	if(empty($login) && empty($mail))
		return ("Les champs doivent être remplis");
	else if(!empty($login) && !empty($mail))
	{
		$result = $user->is_already_in_bdd(array('u_login' => $login, 'mail' => $mail), "AND", NULL);
		if ($result == FALSE)
			return ("Les champs remplis ne sont pas exacts");
	}
	else if(!empty($login) && empty($mail))
	{
		$res = $user->auth($login);
		$mail = $res[0]['mail'];
		if ($mail == "")
			return ("Le champ rempli n'est pas exact");
	}
	else if(empty($login) && !empty($mail))
	{
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
	$message = 'Bonjour '.$login.', clique sur le lien suivant pour réinitialiser ton mot de passe :
	http://localhost:8080//'.$folder.'/index.php?login='.urlencode($login).'&forgot_passwd='.urlencode($forgot_passwd).'
	------------- With <3';
	mail($mail, $subject, $message, $from_who);
	return ("mail_sent");
}

function user_reinitialize_passwd($login, $passwd, $passwd2, $forgot_passwd)
{
	$user = new UsersManager();
	if ($user->is_already_in_bdd(array('u_login' => $login, 'forgot_passwd' => $forgot_passwd), "AND", NULL)){ 
		if ($passwd != $passwd2 || strlen($passwd) < PASSWD_LEN)
			return ("Les mots de passe sont trop courts et/ou ne sont pas identiques");
		else
		{
			$passwd = password_hash($passwd, PASSWORD_DEFAULT);
			$user->change_passwd($passwd, $login);
			$forgot_passwd = md5(microtime(TRUE)*100000);
			$user->forgot_passwd($login, $forgot_passwd, FALSE);
			return ("Ton mot de passe a bien été modifié");
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
	if (!password_verify($passwd, $res[0]['passwd'])) {
		return "Le mot de passe entré est erroné";
	}
	if ($login == $newlogin)
	{
		return("Merci de changer de login");
	}
	if ($newpasswd == $passwd) {
		return "Merci d'entrer un nouveau mot de passe";
	}
	if ($newpasswd != $newpasswd2) {
		return "Merci d'entrer deux mots de passe identiques";
	}
	if ($newpasswd != "" && strlen($newpasswd) < PASSWD_LEN) {
		return "Merci d'entrer un mot de passe plus long";
	}
	if ($newmail != "" && $newmail == $res[0]['mail']) {
		echo "tu as deja ce mail";
		return "pas le bon mail";
	}
	if ($newlogin != ""){
		$user->user_modify($id, "u_login", $newlogin);
		$login = $newlogin;
	}
	if ($newpasswd != "")
		$user->user_modify($id, "passwd", password_hash($newpasswd, PASSWORD_DEFAULT));
	if ($newmail != "")
	{
		$user->user_modify($id, "mail", $newmail);
		$mail = $newmail;
	}
	$subject = "Changement de tes informations personnelles" ;
	$from_who = "From: mail@camagru.com" ;
	$message = 'Bonjour '.$login.', une ou plusieurs de tes informations personnelles viennent d\'être modifiées. Si ce n\'est pas toi, alors qqn a ton mot de passe. contacte-nous <3';
	mail($mail, $subject, $message, $from_who);
	return ("Tes informations ont bien été modifiées");
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
	return ("Tes préférences ont bien été modifiées");
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
			sanitize_input($_POST['passwd']), sanitize_input($_POST['passwd2']), sanitize_input($_POST['forgot_passwd']));
		display_result_userform($res, 'reinitialize_passwd');
	}
	if ($_POST['submit_val'] == 'modify_user') {
			$res = user_modify(sanitize_input($_POST['newlogin']), 
			sanitize_input($_POST['newpasswd']), sanitize_input($_POST['newpasswd2']), sanitize_input($_POST['newmail']), 
			sanitize_input($_POST['passwd']));
		display_result_userform($res, 'modify');
	}
	if ($_POST['submit_val'] == 'Désactiver' || $_POST['submit_val'] == 'Activer') {
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
