<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
$id=$_POST['predmet'];
$upit="SELECT * FROM predmeti WHERE id=$id";
         $rez=mysqli_query($db, $upit);
         $red=mysqli_fetch_all($rez);
        echo JSON_encode($red);
?>