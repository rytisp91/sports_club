<?php
require_once '../vendor/autoload.php';

use app\controller\PostsController;
use app\controller\SiteController;
use app\core\Application;
use app\core\AuthController;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config =[
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/comments', [SiteController::class, 'comments']);

$app->router->get('/register', [SiteController::class, 'register']);

$app->router->get('/login', [SiteController::class, 'login']);

$app->run();