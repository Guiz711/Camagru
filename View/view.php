<?php
function signin_result($res)
{
	if (is_array($res))
	{
		echo $res['msg'];
		$test = "document.getElementById('popup_login_confirm').style.display='block'";
		echo "<div><a href='#' onclick=$test style='width:auto;'>Renvoyer autre mail</a></div>";
	}
	else
		echo $res;
}

function display_result_userform($res, $action)
{
	if ($res == "script" && $action == "get_reinitialize_passwd") {
		echo "<script> display_popup_reinitialize_password() </script>";
	}
	else {
	echo $res;
	echo " ";
	echo $action;
	}
}
?>