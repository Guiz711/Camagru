<?php

function add_path_img($all_imgs) 
{
    foreach ($all_imgs as $key => $value) {
        $all_imgs[$key] = "../img/" . $value . ".jpg"; 
    }
    return ($all_imgs);
}

?>