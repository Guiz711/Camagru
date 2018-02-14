<?php

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
		echo $res['msg'];
		$test = "document.getElementById('popup_login_confirm').style.display='block'";
		echo "<div><a href='#' onclick=$test style='width:auto;'>Renvoyer autre mail</a></div>";
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
	if ($res == "script" && $action == "get_reinitialize_passwd") {
		echo "<script> display_popup_reinitialize_password() </script>";
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
?>



<!-- 
if ($res == "script" && $action == "get_reinitialize_passwd") {
		echo "<script> display_popup_reinitialize_password() </script>";
		return;

	}
	$type = 'popup_result';
	echo "<div id=$type class='popup_result'>".$res."</div>
	<script> display_popup_result($type); 
	delete_popup('$type');
	</script>
	";
	// $type = 'popup_result_userform';
	// echo "<div id=$type class='popup_result_userform'>".$res.$action."</div>
	// <script>
	// display_popup_result($type); 
	// delete_popup('$type');
	// </script>"; -->