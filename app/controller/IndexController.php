<?php

class IndexController
{
    public function index()
    {
       $view = new View();

       $view->render("index");
    }

    public function onama()
    {
       $view = new View();

       $view->render("onama");
    }

    public function kontakt()
    {
       $view = new View();

       $view->render("kontakt");
    }
}