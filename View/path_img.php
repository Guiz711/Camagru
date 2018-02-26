<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}

function add_path_img($all_imgs) 
{
    foreach ($all_imgs as $key => $value) {
        $all_imgs[$key]['path_img'] = "./img/" . $value['img_id'] . ".png";
    }
    // DEBUG_print($all_imgs);
    return ($all_imgs);
}

?>