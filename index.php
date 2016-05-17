<?php
require_once 'Slicket/Library/Autoloader.php';

use Slicket\Router as Router;

session_start();

if ((isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) && (!isset($_COOKIE["rememberMe"]))) { // > 1 hour
    session_unset();
    session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

$router = new Router;
