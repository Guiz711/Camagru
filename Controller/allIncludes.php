<?php 
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
// INCLUDES

// CONFIG
include("../Config/database.php");
include('../Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASSWORD', $DB_PASSWORD);
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
 include("../Controller/utility.php");
?>