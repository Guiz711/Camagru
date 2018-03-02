<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function signup_result($res)
{
	$type = 'popup_signup_result';
	echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."
	<button class='cancel_button' type='button' onclick=\"document.getElementById('$type').style.display='none'\">Annuler</button>	
	</span>
	</div>
	<script> display_popup_result('$type'); 
	</script>
	";
}

function signin_result($res)
{
	if (is_array($res))
	{
		$type = 'popup_login_confirm';
		echo "<script> display_popup_result('$type'); </script> ";
	}
	else
	{
		$type = 'popup_result';
		echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."<br> 
		<button class='cancel_button' type='button' onclick=\"document.getElementById('$type').style.display='none'\">Annuler</button>		
		</span>
		</div>
		<script> display_popup_result('$type');
		 </script>";
	}
}

function display_result_userform($res, $action)
{	
	$type = 'popup_result';
	echo "<div id='$type' class='popup_result' onclick='delete_popup(this.id)' > <span>".$res."<br>
	<button class='cancel_button' type='button' onclick=\"document.getElementById('$type').style.display='none'\">Annuler</button>	
	</span></div>
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