<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once (ROOT . '/../app/config/conf.php');
//require_once (ROOT . '/../app/components/Router.php');
use App\components\Router;
require ROOT . '/../vendor/autoload.php';

$router = new Router();
$router->run();

