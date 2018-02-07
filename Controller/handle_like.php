<?php

// if ($_SESSION['user_id']='unknow') {
//     echo "HEY you need to signin first";
// }
// else {
// header("Content-Type: text/plain");
// echo "truc";
include('../Model/DbManager.class.php');
include('../Model/LikesManager.class.php');
function handle_it($POST) {
// CONFIG
include("../Config/database.php");
include('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);

// VIEW
// include("../View/signin.php");
include("../View/path_img.php");

// MODEL
include("../Model/DbManager.class.php");
include("../Model/SelectElem.class.php");
include("../Model/ImagesManager.class.php");
include("../Model/CommentsManager.class.php");
include("../Model/LikesManager.class.php");
include("../Model/UsersManager.class.php");

// CONTROLLER
include("../Controller/utility.php");
include("../Controller/userForm.php");

// DEBUG

include("../DEBUG_print.php");
    $LikesManager = new LikesManager();
    $heart = "test";
    echo "</ br>        ----> DANS PHP </ br>";
    $data = array('user_id' => $POST['user_id'], 'img_id' => $POST['img_id']);
    // }
    if ($POST['action'] == 'like_it') {
        $LikesManager->insert($data);
        $heart = './resources/002-hearts.png';
    }
    else if ($POST['action'] == 'unlike_it') {
        $id_to_delete = $LikesManager->select_all_id($data, "AND", FALSE);
        print_r($id_to_delete);
        $tab = array('like_id' => $id_to_delete[0]);
        $heart = "./resources/001-favorite.png";
        $LikesManager->delete($tab);
    }
    return("<img src='$heart'>");
}

echo handle_it($_POST);
?>