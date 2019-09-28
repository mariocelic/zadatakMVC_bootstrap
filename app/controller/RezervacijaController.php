<?php

class RezervacijaController extends Controller
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/rezervacije/index',
            ['rezervacije' => Predavac::getRezervacije()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/rezervacije/novi');
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/rezervacije/novi';

        if (!$this->kontrole()) {
            return;
        }

        Rezervacija::novi();
        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(Rezervacija::read($id));
        $this->view->render('privatno/rezervacije/promjeni', ['id' => $id]);
    }

    public function promjeni($id)
    {
        $this->viewGreska = 'privatno/rezervacije/promjeni';
        $this->id = $id;

        if (!$this->kontrole()) {
            return;
        }

        Rezervacija::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!Rezervacija::isDeletable($id)) {
            $this->index();

            return;
        }

        Rezervacija::brisi($id);
        $this->index();
    }

    private function kontrole()
    {
        //nema (još) kontrola
        return true;
    }

    //nju za sada nitko ne poziva
    private function greska($polje, $poruka)
    {
        $this->view->render($this->viewGreska,
            ['greska' => ['polje' => $polje,
                 'poruka' => $poruka, ],
             'id' => $this->id,
            ]);
    }
}
