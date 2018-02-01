<?php

function user_signup($login, $passwd, $email)
{
	$User = new UserManager();
	if (strlen($login) < $LOGIN_LEN)
		return ('Login too short');
	if (strlen($passwd) < $PASSWD_LEN)
		return ('Password too short');
	$User->insert(array('login'
}

?>