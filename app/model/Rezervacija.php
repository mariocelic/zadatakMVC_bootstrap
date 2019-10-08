<?php

class Rezervacija
{
    public static function getRezervacije()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select 
            a.sifra,
            b.prezime as kupac,
            c.nacinplacanja as placanje,
            d.vrstasobe as soba,
            a.datumprijave,
            a.datumodjave
            
        from        rezervacija a
        inner join 	kupac b 	on a.kupac		=b.sifra
        inner join 	placanje c 	on a.placanje	=c.sifra
        inner join 	soba d 	on a.soba		=d.sifra
        
        group by 
        a.sifra,b.prezime,
        c.nacinplacanja,d.vrstasobe,
        a.datumprijave,a.datumodjave
        
        ');
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
