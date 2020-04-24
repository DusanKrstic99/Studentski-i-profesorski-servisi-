<?php
    function konekcija(){
        $db=mysqli_connect("localhost", "root", "", "skola");
        if(!$db)
            return false;
        mysqli_query($db, "SET NAMES utf8");
        return $db;
    }

    function login(){
        if(isset($_SESSION['id']) and isset($_SESSION['podaci']) AND isset($_SESSION['status']))
            return true;
        else
            return false;
    }
    function upisiLog($imeDatoteke, $stringZaUpis){
        $f=fopen($imeDatoteke, "a");
        $stringZaUpis=date("d.m.Y H:i:s")." - $stringZaUpis\r\n";
        fwrite($f, $stringZaUpis);
        fclose($f);
    }
    
?>
 