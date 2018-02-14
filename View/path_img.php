<?php

function add_path_img($all_imgs) 
{
    foreach ($all_imgs as $key => $value) {
        $all_imgs[$key]['path_img'] = "./img/" . $value['img_id'] . ".jpg";
    }
    // DEBUG_print($all_imgs);
    return ($all_imgs);
}

?>