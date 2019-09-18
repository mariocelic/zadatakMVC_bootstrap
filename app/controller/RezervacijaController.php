<?php

class RezervacijaController extends Controller
{
    public function index()
    {
        $this->view->render('privatno/rezervacije/index');
    }
}
