<?php


namespace app\core;

/**
 * Class Router
 *
 * This is where we call controllers and methods
 *
 * @package app\core
 */
class Router
{
    /**
     * This will hold all routes.
     *
     * routes [
     * ['get'  => [
     *  ['/' => function return,],
     *  ['/about' => 'about',],
     * ],
     * ['post' => [
     *  ['/' => function return,],
     *  ['/contact' => function return,],
     * ]]
     * ]
     * ];
     *
     * @var array
     */
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Add get route and callback fn to routes array
     *
     * @param string $path
     * @param string | array | object $callback
     */
    public function get($path, $callback)
    {
        // we search for path arguments
        //"/post/{id}"
        if (strpos($path, '{')):
            $startPos = strpos($path, '{');
            $endPos = strpos($path, '}');
            $argName = substr($path, $startPos + 1, $endPos - $startPos - 1);
            $callback['urlParamName'] = $argName;
            $path = substr($path, 0, $startPos - 1);
        endif;

        $this->routes['get'][$path] = $callback;
    }

    /**
     * This creates post path and handling in routes array.
     *
     * @param $path
     * @param $callback
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Executes user function if it is set in routes array
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // trying to run a route from routes array
        $callback = $this->routes[$method][$path] ?? false;

        // if there is no such route added, we say not exist
        if ($callback === false) :

            $pathArr = explode('/', ltrim($path, '/'));

            // path = "/post/1" take argument value 1
            // path = "/post" skip path argument take
            // extract 1
            if (count($pathArr) === 2) :
                $path = '/' . $pathArr[0];
                $urlParam['value'] = $pathArr[1];
            endif;

            // path = "/post/edit/1" take argument value 1
            if (count($pathArr) === 3) :
                $path = '/' . $pathArr[0] . "/" . $pathArr[1];
                $urlParam['value'] = $pathArr[2];
            endif;

            $callback = $this->routes[$method][$path] ?? null;

            if (!isset($urlParam['value'])) :
                // 404
                $this->response->setResponseCode(404);
                return $this->renderView('_404');
            endif;

        endif;

        // if our callback value is string
        // $app->router->get('/about', 'about');
        if (is_string($callback)) :
            return $this->renderView($callback);
        endif;

        // if our callback is array we handle it whith class instance
        if (is_array($callback)) :
            $instance = new $callback[0];
            Application::$app->controller = $instance;
            $callback[0] = Application::$app->controller;

            // check if we have url arguments in callback array
            if (isset($callback['urlParamName'])) :
                //  [0] => app\controller\PostsController
                //  [1] => post
                //  [urlParamName] => id
                $urlParam['name'] = $callback['urlParamName'];
                // make call back array with 2 members
                array_splice($callback, 2, 1);
            endif;
        endif;

        // main fuction that loads the requested controller and method with paramas
        /**
         * $callback = [Controller, Method, arg1, arg2 ....]
         */
        return call_user_func($callback, $this->request, $urlParam ?? null);

    }

    /**
     * Renders the page and applies the layout
     *
     * @param string $view
     * @return string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        $layout = $this->layoutContent();
        $page = $this->pageContent($view, $params);

        // take layout and replace the {{content}} with the $page content
        return str_replace('{{content}}', $page, $layout);

    }

    /**
     * Returns the layout HTML content
     *
     * @return false|string
     */
    protected function layoutContent()
    {
        if (isset(Application::$app->controller)) :
            $layout = Application::$app->controller->layout;
        else :
            $layout = 'main';
        endif;

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/layout/$layout.php";
        // stop and return buffering
        return ob_get_clean();

    }

    /**
     * Returns only the given page HTML content
     *
     * @param $view
     * @param $params
     * @return false|string
     */
    protected function pageContent($view, $params)
    {

        // a smart way of creating variables dynamically
        // $name = $params['name'];

        foreach ($params as $key => $value) :
            $$key = $value; // name = AlmostLara // $name = AlmostLara
        endforeach;

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/$view.php";
        // stop and return buffering
        return ob_get_clean();
    }
}