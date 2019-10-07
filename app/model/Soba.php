<?php

class Soba
{
    public static function getSobe()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('

            select a.sifra,a.vrstasobe,a.cijenasobe,
            a.slikasobe,a.opissobe, 
            count(b.sifra) as ukupno
            from soba a left join rezervacija b
            on a.sifra=b.soba
            group by a.sifra,a.vrstasobe,a.cijenasobe,
            a.slikasobe,a.opissobe
            order by a.vrstasobe
    
    ');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select * from soba where sifra=:soba
        
        ');
        $izraz->execute(['soba' => $id]);

        return $izraz->fetch(PDO::FETCH_ASSOC);
    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            insert into soba
            (null,vrstasobe,cijenasobe,slikasobe,opissobe)
            values
            (null,:vrstasobe,:cijenasobe,:slikasobe,:opissobe)
        ');

        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        update soba set
        vrstasobe=:vrstasobe,
        cijenasobe=:cijenasobe,
        slikasobe=:slikasobe,
        opissobe=:opissobe
        where sifra=:sifra
        
        ');
        $_POST['sifra'] = $id;
        $izraz->execute($_POST);
    }

    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from soba where sifra=:sifra

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
