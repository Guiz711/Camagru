<?php



function user_signup($login, $passwd, $email)
{
	$user = new UsersManager();
	if (strlen($login) < $LOGIN_LEN)
		return ('Login too short');
	if (strlen($passwd) < $PASSWD_LEN)
		return ('Password too short');
	if ($user->is_already_in_bdd(array('u_login' => $login, 'mail' => $email), "OR", NULL))
		return ('Login or email already exists');
	$user->insert(array('u_login' => $login, 'passwd' => hash("whirlpool", $passwd), 'mail' => $email), NULL);
}

?>