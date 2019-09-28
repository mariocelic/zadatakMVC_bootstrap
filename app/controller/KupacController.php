<?php

class KupacController extends Controller
{
    private $viewGreska = '';
    private $id = 0;

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
        $this->viewGreska = 'privatno/kupci/novi';
        if (!$this->kontrole()) {
            return;
        }

        Kupac::novi();
        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(Kupac::read($id));
        $this->view->render('privatno/kupci/promjeni', ['id' => $id]);
    }

    public function promjeni($id)
    {
        $this->viewGreska = 'privatno/kupci/promjeni';
        $this->id = $id;

        if (!$this->kontrole()) {
            return;
        }

        Kupac::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!Kupac::isDeletable($id)) {
            $this->index();

            return;
        }
        Kupac::brisi($id);
        $this->index();
    }

    private function kontrole()
    {
        if (trim(App::param('ime')) === '') {
            $this->greska('ime', 'Ime obavezno');

            return false;
        }
        if (strlen(App::param('ime')) > 30) {
            $this->greska('ime', 'Ime ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('ime')).')');

            return false;
        }

        if (trim(App::param('prezime')) === '') {
            $this->greska('prezime', 'Obavezan unos');

            return false;
        }

        if (strlen(App::param('prezime')) > 30) {
            $this->greska('prezime', 'Prezime ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('prezime')).')');

            return false;
        }

        if (trim(App::param('adresa')) === '') {
            $this->greska('adresa', 'Obavezan unos');

            return false;
        }

        if (strlen(App::param('adresa')) > 30) {
            $this->greska('adresa', 'Adresa ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('adresa')).')');

            return false;
        }

        if (trim(App::param('grad')) === '') {
            $this->greska('grad', 'Obavezan unos');

            return false;
        }

        if (strlen(App::param('grad')) > 30) {
            $this->greska('grad', 'Grad ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('grad')).')');

            return false;
        }

        if (trim(App::param('drzava')) === '') {
            $this->greska('drzava', 'Obavezan unos');

            return false;
        }

        if (strlen(App::param('drzava')) > 30) {
            $this->greska('drzava', 'Drzava ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('drzava')).')');

            return false;
        }

        if (trim(App::param('kontakt')) === '') {
            $this->greska('kontakt', 'Obavezan unos');

            return false;
        }

        if (strlen(App::param('kontakt')) > 30) {
            $this->greska('kontakt', 'Kontakt ne smije imati više od 30 znakova (trenutno ima: '.
        strlen(App::param('kontakt')).')');

            return false;
        }
    }

    private function greska($polje, $poruka)
    {
        $this->view->render('privatno/kupci/novi',
                ['greska' => ['polje' => $polje,
                     'poruka' => $poruka, ],
                     'id' => $this->id,
                ]);
    }
}
