<?php

class SobaController extends UlogaOperater
{
    private $viewGreska = '';
    private $id = 0;

    public function index()
    {
        $this->view->render('privatno/sobe/index',
            ['sobe' => Soba::getSobe()]);
    }

    public function pripremaNovi()
    {
        $this->view->render('privatno/sobe/novi',
        ['slikesoba' => Slikasobe::getSlikesoba()]);
    }

    public function novi()
    {
        $this->viewGreska = 'privatno/sobe/novi';

        if (!$this->kontrole()) {
            return;
        }

        $zadnji = Soba::novi();

        if (!empty($_FILES['slika'])) {
            $path = App::config('putanja').'public/img/sobe/'.$zadnji.'.jpg';
            // var_dump($path);
            move_uploaded_file($_FILES['slika']['tmp_name'], $path);
        }

        $this->pripremaPromjeni(Soba::novi());
    }

    public function pripremaPromjeni($id)
    {
        $soba = Soba::read($id);
        App::setParams($soba);
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

        if (!empty($_FILES['slika'])) {
            $path = App::config('putanja').'public/img/sobe/'.$id.'.jpg';
            var_dump($path);
            move_uploaded_file($_FILES['slika']['tmp_name'], $path);
        }

        $this->view->render('privatno/sobe/promjeni',
        ['id' => $id,
        'slikesoba' => Slikasobe::getSlikesoba(),
        'cssFile' => '<link rel="stylesheet" href="'.App::config('url').'public/css/jquery-ui.css">',
        'jsLib' => '<script src="'.App::config('url').'public/js/vendor/jquery-ui.js"></script>',
        'javascript' => '
        <script>var soba='.$id.';</script>
        <script src="'.App::config('url').'public/js/sobe/skripta.js"></script>', ]);
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
