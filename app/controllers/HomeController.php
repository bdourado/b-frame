<?php


class HomeController extends MainController
{

    public function index()
    {
        // Use the example model
        $userModel = new UserModel();
        $userData = $userModel->getUser(1);

        $params = [
            'title' => 'BFrame',
            'author' => $userData['name'],
            'role' => $userData['role'],
            'date' => date('d/m/Y', time()),
            'text' => 'Welcome to BFrame, a tiny and super simple Framework',
            'linkedin' => 'https://www.linkedin.com/in/bruno-dourado-8a6a4813/',
            'github' => 'https://github.com/bdourado/'
        ];

        $this->view('welcome', $params);
    }

}