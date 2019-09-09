<?php

class PredavacController extends Controller
{
    public function index()
    {
        $this->view->render('privatno/predavaci/index');
    }
}
