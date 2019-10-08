<?php

class PlacanjeController extends Controller
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/placanja/index',
            ['placanja' => Placanje::getPlacanja()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/placanja/novi');
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/placanja/novi';

        if (!$this->kontrole()) {
            return;
        }

        Placanje::novi();
        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(Placanje::read($id));
        $this->view->render('privatno/placanja/promjeni',
        ['id' => $id]);
    }

    public function promjeni($id)
    {
        $this->viewGreska = 'privatno/placanja/promjeni';
        $this->id = $id;

        if (!$this->kontrole()) {
            return;
        }

        Placanje::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!Placanje::isDeletable($id)) {
            $this->index();

            return;
        }

        Placanje::brisi($id);
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
