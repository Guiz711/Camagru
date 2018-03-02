<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
?>

<div id="popup_photomontage_uploaded" class="popup_login">
<div class="content_popup">
    <a>Ta photo a bien été uploadée</a>
	<div class="cancel_button"><button type="button" onclick="document.getElementById('popup_photomontage_uploaded').style.display='none'">Annuler</button></div>
</div></div>

<div id="popup_photomontage_not_uploaded" class="popup_login">
<div class="content_popup">
    <a>Mauvais format</a>
	<div class="cancel_button"><button type="button" onclick="document.getElementById('popup_photomontage_not_uploaded').style.display='none'">Annuler</button></div>
</div></div>