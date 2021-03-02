<?php


namespace app\controller;


use app\core\Application;
use app\core\Controller;
use app\core\Request;

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

    public function comments()
    {
        $params = [
            'currentPage' => 'comments',
        ];

        return $this->render('comments', $params);
    }

    public function login()
    {
        $params = [
            'currentPage' => 'login',
        ];

        return $this->render('login', $params);
    }
}