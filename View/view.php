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
	{
		$type = 'popup_result';
		echo "<div id='popup_result' class='popup_result'>".$res."</div>
		<script> display_popup_result(); 
		delete_popup('$type');
		</script>";
	}
}

function display_result_userform($res, $action)
{
	if ($res == "script" && $action == "get_reinitialize_passwd") {
		echo "<script> display_popup_reinitialize_password() </script>";
		return;
	}
	$type = 'popup_result';
	echo "<div id='popup_result' class='popup_result'>".$res.$action."</div>
	<script> display_popup_result(); 
	delete_popup('$type');
	</script>";
}
?>
