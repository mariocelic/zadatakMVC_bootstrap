<?php

class KupacController extends Controller
{
    public function index()
    {
        $this->view->render('privatno/kupci/index',
        ['kupci' => Kupac::getKupci()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/kupci/novi');
    }

    public function novi()
    {
        Kupac::novi();
        $this->index();
    }
}
