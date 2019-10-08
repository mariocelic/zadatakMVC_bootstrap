<?php

class Placanje
{
    public static function getPlacanja()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('

            select a.sifra,a.nacinplacanja, 
            count(b.sifra) as ukupno
            from placanje a left join rezervacija b
            on a.sifra=b.placanje
            group by a.sifra,a.nacinplacanja
            order by a.nacinplacanja
    
    ');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from placanje where sifra=:placanje
        
        ');
        $izraz->execute(['placanje' => $id]);

        return $izraz->fetch(PDO::FETCH_ASSOC);
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            insert into placanje
            values
            (null,:nacinplacanja)
        ');

        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        update placanje set
        nacinplacanja=:nacinplacanja
        
        where sifra=:sifra
        
        ');
        $_POST['sifra'] = $id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from placanje where sifra=:sifra

        ');

        $izraz->execute(['sifra' => $id]);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select count(sifra) from rezervacija where placanje=:placanje
        
        ');
        $izraz->execute(['placanje' => $id]);
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
