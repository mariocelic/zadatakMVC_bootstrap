<?php

class RezervacijaController extends Controller
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

        Rezervacija::novi();
        $this->pripremaPromjeni(Rezervacija::novi());
    }

    public function pripremaPromjeni($id)
    {
        $rezervacija = Rezervacija::read($id);
        $rezervacija['datumprijave'] = date('c', strtotime($rezervacija['datumprijave']));
        App::setParams($rezervacija);

        $this->view->render('privatno/rezervacije/promjeni',
       ['id' => $id,
       'kupci' => Kupac::getKupci(),
       'placanja' => Placanje::getPlacanja(),
       'sobe' => Soba::getSobe(), ]);
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
