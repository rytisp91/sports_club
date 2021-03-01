<?php


namespace app\core;


/**
 * Class Response
 * @package app\core
 */
class Response
{
    /**
     * Sets http response code
     *
     * @param int $code
     */
    public function setResponseCode(int $code)
    {
        http_response_code($code);
    }
}