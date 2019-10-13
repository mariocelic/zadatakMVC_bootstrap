<?php

class SlikaSobeController extends Controller
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/slikesoba/index',
            ['slikesoba' => SlikaSobe::getSlikeSoba()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/slikesoba/novi');
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/slikesoba/novi';

        if (!$this->kontrole()) {
            return;
        }

        SlikaSobe::novi();
        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(SlikaSobe::read($id));
        $this->view->render('privatno/slikesoba/promjeni',
        ['id' => $id]);
    }

    public function promjeni($id)
    {
        $this->viewGreska = 'privatno/slikesoba/promjeni';
        $this->id = $id;

        if (!$this->kontrole()) {
            return;
        }

        SlikaSobe::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!SlikaSobe::isDeletable($id)) {
            $this->index();

            return;
        }

        SlikaSobe::brisi($id);
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
