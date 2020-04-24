<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
$id=$_POST['predmet'];
$upit="SELECT * FROM prijava WHERE idPredmeta=$id";
$rez=mysqli_query($db, $upit);
$broj = mysqli_num_rows($rez);
if(mysqli_error($db)){ 
echo mysqli_error($db);
}
else echo $broj;
?>