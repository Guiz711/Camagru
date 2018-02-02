<?php

function add_path_img($all_imgs) {
    foreach ($all_imgs as $value) {
        $value = "../img/" . $value . ".jpg"; 
    }
    print_r($all_imgs);
    return ($all_imgs);
}

?>