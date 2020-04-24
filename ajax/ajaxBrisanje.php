<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
$id=$_POST['ZaBrisanje'];
$upit="DELETE FROM predmeti WHERE id=$id";
$rez=mysqli_query($db, $upit);
$upit2="DELETE FROM prijava WHERE idPredmeta=$id";
$rez=mysqli_query($db, $upit2);
if(mysqli_error($db)){ 
echo mysqli_error($db);
}
else echo 1;
?>