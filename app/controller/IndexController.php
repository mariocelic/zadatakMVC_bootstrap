<?php

class IndexController
{
    public function index()
    {
        $view = new View();

        $view->render('index');
    }

    public function onama()
    {
        $view = new View();

        $view->render('onama');
    }

    public function kontakt()
    {
        $view = new View();

        $view->render('kontakt');
    }

    public function login()
    {
        $view = new View();

        $view->render('login');
    }

    public function autoriziraj()
    {
        $view = new View();

        if (App::param('email') == '' && App::param('password') == '') {
            $view->render('login', ['greska' => 'Obavezan unos email i lozinke']);

            return;
        }

        $db = DB::getInstance();
        $izraz = $db->prepare('select * 
        from operater 
        where email=:email');

        $izraz->execute(['email' => App::param('email')]);
        if ($izraz->rowCount() == 0) {
            $view->render('login', ['greska' => 'Nepostojeci korisnik']);

            return;
        }

        $red = $izraz->fetch();
        if (!password_verify(App::param('password'), $red->lozinka)) {
            $view->render('login', ['greska' => 'Netocna lozinka']);

            return;
        }

        $korisnik = new stdClass();
        $korisnik->email = $red->email;
        $korisnik->imePrezime = $red->ime.' '.$red->prezime;
        $_SESSION['autoriziran'] = $korisnik;

        $view->render('privatno/nadzornaPloca');
    }

    public function logout()
    {
        unset($_SESSION['autoriziran']);
        session_destroy();

        $view = new View();

        $view->render('login');
    }
}
