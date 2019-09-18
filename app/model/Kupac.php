<?php

class Kupac
{
    public static function getKupci()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('

            select a.sifra,a.ime,a.prezime,
            a.adresa,a.grad,a.drzava,a.kontakt, 
            count(b.sifra) as ukupno
            from kupac a left join rezervacija b
            on a.sifra=b.kupac
            group by a.sifra,a.ime,a.prezime,
            a.adresa,a.grad,a.drzava,a.kontakt
    
    ');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            insert into kupac values
            (null,:ime,:prezime,:adresa,:grad,:drzava,:kontakt)
        ');

        $izraz->execute($_POST);
    }
}
