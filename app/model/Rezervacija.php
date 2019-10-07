<?php

class Rezervacija
{
    public static function getRezervacije()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select 
            a.sifra,
            a.kupac,
            b.kupac as kupac,
            concat(d.ime,' ',d.prezime) as predavac,
            a.brojpolaznika,
            a.datumpocetka,
            count(e.polaznik) as ukupno
        from 		grupa a
        inner join 	smjer b 	on a.smjer		=b.sifra
        inner join 	predavac c 	on a.predavac	=c.sifra
        inner join 	osoba d 	on c.osoba		=d.sifra
        left  join 	clan e 		on e.grupa		=a.sifra
        group by 
        a.sifra,a.naziv,b.naziv,
        concat(d.ime,' ',d.prezime),
        a.brojpolaznika,a.datumpocetka
        
        ");
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from rezervacija where sifra=:rezervacija
        
        ');
        $izraz->execute(['rezervacija' => $id]);

        return $izraz->fetch(PDO::FETCH_ASSOC);
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        insert into rezervacija
        (null,kupac,placanje,soba,datumprijave,datumodjave)
        values
        (null,:kupac,:placanje,:soba,:datumprijave,:datumodjave)
        
        ');
        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        update rezervacija set
        kupac=:kupac,
        placanje=:placanje,
        soba=:soba,
        datumprijave=:datumprijave,
        datumodjave=:datumodjave
        where sifra=:sifra
        
        ');
        $_POST['sifra'] = $id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        delete from rezervacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra' => $id]);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select count(kupac) from kupac where rezervacija=:rezervacija
        
        ');
        $izraz->execute(['rezervacija' => $id]);
        $ukupno = $izraz->fetchColumn();

        return $ukupno == 0;
    }
}
