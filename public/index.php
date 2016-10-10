<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once (ROOT . '/../app/config/conf.php');
//require_once (ROOT . '/../app/components/Router.php');
use App\components\Router;
require ROOT . '/../vendor/autoload.php';
session_start();

//if (isset($_GET['contentId'])) {
  //  setcookie("contentId", $_GET['contentId']);
//}

if (isset($_GET['contentId'])) {
    $contentId = $_GET['contentId'];
} 
if (isset($_POST['contentId'])) {
    $contentId = $_POST['contentId'];
} 

$router = new Router();
$router->run();

