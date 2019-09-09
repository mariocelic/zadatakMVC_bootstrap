<?php

class PolaznikController extends Controller
{
    public function index()
    {
        $this->view->render('privatno/polaznici/index');
    }
}
