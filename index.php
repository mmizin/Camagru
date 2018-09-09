<?php
session_start(['cookie_lifetime' => 86400]);




ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));


require_once ROOT . '/core/Route.php';
require_once ROOT . '/core/View.php';
require_once ROOT . '/core/Model.php';
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/PHPMailer/PHPMailer.php';

$router = new Route();
$router->start();
