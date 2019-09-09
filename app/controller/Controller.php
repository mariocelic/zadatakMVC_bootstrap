<?php

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
        if (!isset($_SESSION['autoriziran'])) {
            $this->view->render('login');
            exit;
        }
    }
}
