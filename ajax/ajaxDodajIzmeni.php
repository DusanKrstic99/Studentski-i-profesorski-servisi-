<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
$id=$_POST['id'];
    $naziv=$_POST['naziv'];
    $datum=$_POST['datum'];
    $nacinpolaganja=$_POST['nacinpolaganja'];
if($id=="")
    $upit="INSERT INTO predmeti (naziv, datum, nacinpolaganja, idProfesora) VALUES ('{$naziv}', '{$datum}', {$nacinpolaganja}, {$_SESSION['id']})";
else
    $upit="UPDATE predmeti SET naziv='{$naziv}', datum='{$datum}', nacinpolaganja={$nacinpolaganja} WHERE id=$id";
         $rez=mysqli_query($db, $upit);
         if(mysqli_error($db)){ 
            echo 1;
            }
        else if($id=="")
            echo "Uspešno snimljeni podaci";
            else echo "Uspešno izmenjeni podaci";

?>