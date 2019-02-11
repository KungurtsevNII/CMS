<?php

use App\App\Router;
use App\App\Controller;
use App\App\Application;

error_reporting(E_ALL);
ini_set('display_errors',true);

require_once 'bootstrap.php';

$router = new Router();

// Регистрация маршрута через действие контроллера.
$router->get('/', Controller::class . '@index');
$router->get('/about', Controller::class . '@about');

// Регистрация маршрута через callback функцию.
$router->get('/info', function() {
	return new \App\View\View('info', ['title' => 'Info page']);
});

$router->get('/post/*/*/', function($param1, $param2) {
    return "Test Page With param1=$param1 param2=$param2";
});

$router->get('/post/*/', function($param1) {
    return "Test Page With param1=$param1";
});

$router->get('/products/*/*/', Controller::class . '@products');

$application = new Application($router);

$application->run();
