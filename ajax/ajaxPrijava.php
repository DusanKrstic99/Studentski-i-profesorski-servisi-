<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
$id=$_POST['id'];
$student=$_SESSION['id'];
$upit="SELECT * FROM prijava WHERE idPredmeta=$id AND idStudenta=".$_SESSION['id'];
$rez=mysqli_query($db, $upit);
if(mysqli_num_rows($rez)>0){
    echo "Vec ste prijavili taj predmet";
    exit();
}
    $upit2="INSERT INTO prijava (idStudenta,idPredmeta) VALUES ({$student}, {$id})";
    mysqli_query($db, $upit2);
if(mysqli_error($db)){ 
echo mysqli_error($db);
}
else upisiLog("../logovi/prijavaispita.txt", "Uspešna prijava ispita $id za korisnika {$_SESSION['podaci']}"); echo 9;


?>