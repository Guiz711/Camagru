<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function sanitize_input($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

?>