<?php

class RezervacijaController extends UlogaOperater
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/rezervacije/index',
            ['rezervacije' => Rezervacija::getRezervacije()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/rezervacije/novi',
        ['kupci' => Kupac::getKupci(),
        'placanja' => Placanje::getPlacanja(),
        'sobe' => Soba::getSobe(), ]);
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/rezervacije/novi';

        if (!$this->kontrole()) {
            return;
        }

        $this->pripremaPromjeni(Rezervacija::novi());
    }

    public function pripremaPromjeni($id)
    {
        $rezervacija = Rezervacija::read($id);

        App::setParams($rezervacija);

        $this->view->render('privatno/rezervacije/promjeni',
       ['id' => $id,
       'kupci' => Kupac::getKupci(),
       'placanja' => Placanje::getPlacanja(),
       'sobe' => Soba::getSobe(),
        'cssFile' => '<link rel="stylesheet" href="'.App::config('url').'public/css/jquery-ui.css">',
       'jsLib' => '<script src="'.App::config('url').'public/js/vendor/jquery-ui.js"></script>',
       'javascript' => '
       <script>var rezervacija='.$id.';</script>
       <script src="'.App::config('url').'public/js/rezervacije/skripta.js"></script>', ]);
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
        Rezervacija::brisi($id);
        $this->index();
    }

    private function kontrole()
    {
        return true;
    }

    private function greska($polje, $poruka)
    {
        $this->view->render($this->viewGreska,
            ['greska' => ['polje' => $polje,
                 'poruka' => $poruka, ],
             'id' => $this->id,
            ]);
    }
}
