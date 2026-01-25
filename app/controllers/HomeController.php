<?php


class HomeController extends MainController
{

    public function index()
    {
        $params = [
            'title' => 'BFrame',
            'author' => 'Bruno M. Dourado',
            'date' => date('d/m/Y', time()),
            'text' => 'Welcome to my tiny and super simple Framework',
            'linkedin' => 'https://www.linkedin.com/in/bruno-dourado-8a6a4813/',
            'github' => 'https://github.com/bdourado/'
        ];

        $this->view('welcome', $params);
    }

}