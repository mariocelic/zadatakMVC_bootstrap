<?php

class Slikasobe
{
    public static function getSlikesoba()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('

            select a.sifra,a.slika,
            count(b.sifra) as ukupno
            from slikasobe a left join soba b
            on a.sifra=b.slikasobe
            group by a.sifra
            
    ');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from slikasobe where sifra=:slikasobe
        
        ');
        $izraz->execute(['slikasobe' => $id]);

        return $izraz->fetch(PDO::FETCH_ASSOC);
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            insert into slikasobe
            values
            (null,:slika)
        ');

        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        update slikasobe set
        slika=:slika
        
        where sifra=:sifra
        
        ');
        $_POST['sifra'] = $id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from slikasobe where sifra=:sifra

        ');

        $izraz->execute(['sifra' => $id]);
    }

    public static function isDeletable($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select count(sifra) from rezervacija where soba=:soba
        
        ');
        $izraz->execute(['soba' => $id]);
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
