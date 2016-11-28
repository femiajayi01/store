<?php
    
require_once("config.php");
require_once("functions.php");
require_once("session.php");
require_once("database.php");
require_once("database_object.php");
require_once("user.php");
require_once("product.php");
require_once("category.php");
require_once("customer.php");
require_once("review.php");
require_once("orders.php");
require_once("user_cart.php");
require_once("service_result.php");
require_once("order_items.php");


defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? NULL : define('SITE_ROOT', $_SERVER["APPL_PHYSICAL_PATH"]);


?>


