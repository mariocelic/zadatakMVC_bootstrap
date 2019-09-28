<?php

class SobaController extends Controller
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/sobe/index',
            ['sobe' => Predavac::getSobe()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/sobe/novi');
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/sobe/novi';

        if (!$this->kontrole()) {
            return;
        }

        Soba::novi();
        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(Soba::read($id));
        $this->view->render('privatno/sobe/promjeni', ['id' => $id]);
    }

    public function promjeni($id)
    {
        $this->viewGreska = 'privatno/sobe/promjeni';
        $this->id = $id;

        if (!$this->kontrole()) {
            return;
        }

        Soba::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!Soba::isDeletable($id)) {
            $this->index();

            return;
        }

        Soba::brisi($id);
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
