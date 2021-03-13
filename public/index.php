<?php
// front controller

// composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

//spl_autoload_register(function ($class) {
//    $root = dirname(__DIR__); // get parent directory
//    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
//    if (is_readable($file)) {
//        require $file;
//    }
//});
// error and exception handling
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

// start session
session_start();

// routing
$router = new Core\Router();
// add routes
//$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('admin/{controller}/{action}');
$router->addToRouteList('', ['controller' => 'Home', 'action' => 'index']);
$router->addToRouteList('login', ['controller' => 'login', 'action' => 'new']);
$router->addToRouteList('profile', ['controller' => 'profile', 'action' => 'show']);
$router->addToRouteList('logout', ['controller' => 'login', 'action' => 'destroy']);
$router->addToRouteList('{controller}/{action}');
$router->addToRouteList('{controller}/{id:\d+}/{action}');
$router->addToRouteList('admin/{controller}/{action}', ['namespace' => 'Admin']);

$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);