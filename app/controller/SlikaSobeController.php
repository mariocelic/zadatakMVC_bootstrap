<?php

class SlikasobeController extends UlogaOperater
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/slikesoba/index',
            ['slikesoba' => Slikasobe::getSlikesoba()]);
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

        $zadnji = Slikasobe::novi();

        if (!empty($_FILES['slika'])) {
            $path = App::config('putanja').'public/img/sobe/'.$zadnji.'.jpg';
            // var_dump($path);
            move_uploaded_file($_FILES['slika']['tmp_name'], $path);
        }

        $this->index();
    }

    public function pripremaPromjeni($id)
    {
        App::setParams(Slikasobe::read($id));
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

        Slikasobe::promjeni($id);
        $this->index();
    }

    public function brisanje($id)
    {
        if (!Slikasobe::isDeletable($id)) {
            $this->index();

            return;
        }

        Slikasobe::brisi($id);
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
