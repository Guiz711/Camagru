<?php
if (!isset($vault) || $vault !== true)
{
	header('HTTP/1.0 403 Forbidden');
	die();
}
// CONFIG
require_once("./Config/database.php");
require_once('./Config/config.php');
define('DB_USER', $DB_USER);
define('DB_PASSWORD', $DB_PASSWORD);
define('DB_DSN', $DB_DSN);

// VIEW

require_once("./View/signin.php");
require_once("./View/signup.php");
require_once("./View/path_img.php");
require_once("./View/view.php");
require_once("./View/modify_user.php");
require_once("./View/photomontageuploaded.php");

// MODEL
require_once("./Model/DbManager.class.php");
require_once("./Model/SelectElem.class.php");
require_once("./Model/ImagesManager.class.php");
require_once("./Model/CommentsManager.class.php");
require_once("./Model/LikesManager.class.php");
require_once("./Model/UsersManager.class.php");

// CONTROLLER
require_once("./Controller/utility.php");
require_once("./Controller/userForm.php");
// include("./Controller/displayMedia.php");
// require_once("./Controller/handleAjax.php");

?>