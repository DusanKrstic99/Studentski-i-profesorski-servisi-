<?php session_start();
require_once("funkcije.php");
$db=konekcija();
if(!$db)
{
    echo "Greška prilikom konekcije";
    exit();
}
if(isset($_GET['odjava']))
{
    upisiLog("logovi/logovanja.txt", "Odjava korisnika {$_SESSION['podaci']}");
    unset($_SESSION['id']);
    unset($_SESSION['podaci']);
    unset($_SESSION['status']);
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zadatak</title>
    <style>
        .vest{
            background-color:green;
            width: 300px;
            padding:2px;
            margin:2px;
        }
        .prosao{
            background-color:red;
            width: 300px;
            padding:2px;
            margin:2px;
        }
        .dugme{
            background-color:#e0e0e0;
            border:2px solid black;
            cursor: pointer;
            padding:2px;
            margin:2px;
            text-align: center; 
        }
    </style>
    <script src="jquery-3.4.1.js"></script>
   
</head>
<body>


<?php
if(!login()){
    echo"<input type='text' id='korime' placeholder='Unesite korisničko ime'>";
    echo"<input type='text' id='lozinka' placeholder='Unesite lozinku'> ";
    echo"<button type='button' id='prijava'>Prijavi se</button>";
}
else if($_SESSION['status']!="Profesor")
echo $_SESSION['podaci']."<a href='index.php?odjava'>Odjavite se</a>  <a href='index.php'>Pocetna</a>";
else
echo $_SESSION['podaci']."<a href='index.php?odjava'>Odjavite se</a>  <a href='index.php'>Pocetna</a> <a href='prof.php'>Administrativni deo</a>";


    $upit="SELECT * FROM vwpredmeti ORDER BY datum ASC";
    $rez=mysqli_query($db, $upit);
    while($red=mysqli_fetch_object($rez))
    {   if(strtotime($red->datum)<time()){
        echo "<div class='prosao'>";
    }
    else echo "<div class='vest'>";
        echo "<div>$red->naziv</div>";
        echo "<div><i>$red->datum</i></div>";
        echo "<div>Profesor: $red->ime $red->prezime</div>";
        echo "<div>Nacin polaganja: $red->nazivNP</div>";
        if(login()){
         if($_SESSION['status']!="Profesor"){
            if(strtotime($red->datum)<time()){
                echo "</div>";}
            else {
                $idPredmeta=$red->id;
                echo "<div class='dugme' onclick='prijaviIspit($idPredmeta)'>Prijavi ispit</div>";
            echo "</div>";}
            }
            else{
                echo"</div>";
            }
        }
        else{
            echo "</div>";}
        }
    ?>
    <?php
    if(login()){
    if($_SESSION['status']!="Profesor"){
        $upit2="SELECT * FROM prijava WHERE idStudenta=".$_SESSION['id'];
        $rez=mysqli_query($db, $upit2);
        if(mysqli_num_rows($rez) == 0){
            echo "Niste prijavili jos ni jedan predmet.";
        }
        else{
            echo "<h4>Broj prijavljenih ispita: ".mysqli_num_rows($rez)."</h4>";
            while($red=mysqli_fetch_object($rez))
            {
                $upit="SELECT * FROM predmeti WHERE id=$red->idPredmeta";
                $pomrez=mysqli_query($db, $upit);
                $pomred=mysqli_fetch_object($pomrez);
                echo "$pomred->datum - $pomred->naziv<br>";
        }
    }
}
else{}
    }
else{} 
    ?>
<script>
$("#prijava").click(function(){
            let a=$("#korime").val();
            let b=$("#lozinka").val();
            if(a=="" || b=="")
            {
                alert("Svi podaci su obavezni");
                return false;
            }
            $.post("ajax/ajaxIndex.php", {korime: a, lozinka:b}, function(response){
                if(response!=1)alert(response);
                else document.location.assign("index.php");
            })
        });
    function prijaviIspit(idPredmeta){
    $.post("ajax/ajaxPrijava.php", {id: idPredmeta}, function(response){
        if(response==9) document.location.assign("index.php");
        else alert(response);
    })
}   
</script>
</body>
</html>