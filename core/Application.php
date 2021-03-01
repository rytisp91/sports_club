<?php


namespace app\core;

/**
 * Class Application
 *
 * This is main application
 *
 * @package app\core
 */
class Application
{
    /**
     * This is instance of Router class
     *
     * We will need routing in all our application. So we will have it as a property;
     *
     * @var Router
     */
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    // a way to get this app's properties and methods where we need them,
    public static Application $app;
    public Controller $controller;
    public Database $db;
    public Session $session;

    public function __construct($rootPath, $config)
    {
        $this->session = new Session();
        // static property assignment
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);

    }

    /**
     * This run our application
     */
    public function run()
    {
        echo $this->router->resolve();

    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}