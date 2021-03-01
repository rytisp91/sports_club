<?php


namespace app\core;

/**
 *
 *
 * Class Request
 * @package app\core
 */
class Request
{
    /**
     * Get user page form url
     *
     * [REQUEST_URI] => /todos?id=5
     * extract /todos
     *
     * @return string
     */
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $questionPosition = strpos($path, '?');

        if ($questionPosition !== false) :
            $path = substr($path, 0, $questionPosition);
        endif;

        // if user entered address with slash on the right we remove it
        if (strlen($path) > 1) :
            $path = rtrim($path, '/');
        endif;


        return $path;
    }

    /**
     * This will return http method get or post.
     *
     * @return string
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * helper fn return true if server method is get
     *
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    /**
     * helper fn return true if server method is post
     *
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method() === 'post';
    }

    /**
     * Sanitize get and post arrays with html special chars
     *
     * @return array
     */
    public function getBody()
    {
        // store clean values
        $body = [];

        // what type of request
        if ($this->isPost()) :
            foreach ($_POST as $key => $value):
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            endforeach;
        endif;

        if ($this->isGet()) :
            foreach ($_GET as $key => $value):
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            endforeach;
        endif;

        return $body;
    }

    /**
     * Simple way to redirect to a location
     *
     * @param $whereTo string
     */
    public function redirect($whereTo)
    {
        header("Location: $whereTo");
    }
}