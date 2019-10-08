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
            order by a.prezime           
    
    ');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from kupac where sifra=:kupac
        
        ');
        $izraz->execute(['kupac' => $id]);

        return $izraz->fetch(PDO::FETCH_ASSOC);
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            insert into kupac 
            values
            (null,:ime,:prezime,:adresa,:grad,:drzava,:kontakt)
        ');

        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        update kupac set
        ime=:ime,
        prezime=:prezime,
        adresa=:adresa,
        grad=:grad,
        drzava=:drzava,
        kontakt=:kontakt
        where sifra=:sifra
        
        ');
        $_POST['sifra'] = $id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from kupac where sifra=:sifra

        ');

        $izraz->execute(['sifra' => $id]);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select count(sifra) from rezervacija where kupac=:kupac
        
        ');
        $izraz->execute(['kupac' => $id]);
        $ukupno = $izraz->fetchColumn();

        return $ukupno == 0;

        /*
        // Linija 59 je zamjena za ovaj if else
        if($ukupno==0){
            return true;
        }else{
            return false;
        }
        */
    }
}
