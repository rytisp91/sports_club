<?php
require_once '../vendor/autoload.php';

use app\controller\PostsController;
use app\controller\SiteController;
use app\core\Application;
use app\core\AuthController;

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->run();