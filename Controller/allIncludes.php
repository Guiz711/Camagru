<?php 
// INCLUDES
// CONFIG
include("../Config/database.php");
include('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_DSN', $DB_DSN);
// VIEW
include("../View/path_img.php");
include("../View/view.php");
// MODEL
include("../Model/DbManager.class.php");
include("../Model/SelectElem.class.php");
include("../Model/ImagesManager.class.php");
include("../Model/CommentsManager.class.php");
include("../Model/LikesManager.class.php");
include("../Model/UsersManager.class.php");
// CONTROLLER
 include("./utility.php");
// include("../Controller/userForm.php");
// DEBUG
include("../DEBUG_print.php");
?>