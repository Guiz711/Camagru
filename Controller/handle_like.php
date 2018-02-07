<?php

// if ($_SESSION['user_id']='unknow') {
//     echo "HEY you need to signin first";
// }
// else {
// header("Content-Type: text/plain");
// echo "truc";

function handle_it($POST) {
    $LikesManager = new LikesManager();
    $heart = "test";
    // echo "</ br> ----> DANS PHP </ br>";
    $data = array('user_id' => $POST['user_id'], 'img_id' => $POST['img_id']);
    // }
    if ($POST['action'] == 'like_it') {
        // $LikesManager->insert($data);
        $heart = './resources/002-hearts.png';
    }
    else if ($POST['action'] == 'unlike_it') {
        // $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
        $heart = "./resources/001-favorite.png";
        // $LikesManager->delete($id_to_delete[0]);
    }
    return("<img src='$heart'>");
}

echo handle_it($_POST);
?>