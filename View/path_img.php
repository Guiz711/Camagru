<?php

function add_path_img($all_imgs) 
{
    $tab = array();
    foreach ($all_imgs as $value) {
        $tab[$value] = "./img/" . $value . ".jpg";
    }
    return ($tab);
}

?>