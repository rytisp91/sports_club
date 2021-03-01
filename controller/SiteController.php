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
        $params = [
            'pageName' => "Sports Club",
        ];

        return $this->render('home', $params);
    }

}