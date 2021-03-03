<?php

namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class SiteController handles Home page get request
 * 
 * @package app\controller
 */
class SiteController extends Controller
{
    /**
     * This handles Home page get request
     *
     * @return string|string[]
     */
    public function home()
    {
        $params = [];

        return $this->render('home', $params);
    }

}