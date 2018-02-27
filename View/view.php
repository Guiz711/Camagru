<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function signup_result($res)
{
	$type = 'popup_signup_result';
	echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."</span></div>
	<script> display_popup_result('$type'); 
	</script>
	";
}

function signin_result($res)
{
	if (is_array($res))
	{
		// $test = "document.getElementById('popup_login_confirm').style.display='block'; delete_popup(popup_result_not_confirm)";
		// $send = "<a href='#' onclick=$test style='width:auto;'> Renvoyer autre mail</a>";
		$type = 'popup_login_confirm';
		// echo "<div id='$type' class='popup_result' onclick='delete_popup(popup_login_confirm)' > <span>".$res['msg'].$send."</span></div>
		echo "<script> display_popup_result('$type'); 
		</script> ";
		// echo $res['msg'];
		// $test = "document.getElementById('popup_login_confirm').style.display='block'";
		// echo "<div><a href='#' onclick=$test style='width:auto;'>Renvoyer autre mail</a></div>";
	}
	else
	{
		$type = 'popup_result';
		echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."</span></div>
		<script> display_popup_result('$type'); 
		</script>
		";
	}
}

function display_result_userform($res, $action)
{	
	$type = 'popup_result';
	echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."</span></div>
	<script> display_popup_result('$type'); 
	</script>
	";
}

function display_reinitialize_passwd($res, $action, $forgot_passwd)
{	
	if ($res == "script" && $action == "get_reinitialize_passwd") {
		echo "<script> display_popup_reinitialize_password('$forgot_passwd') </script>";
	}
}
?>