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
   echo "Ne mozete da vidite ovaj deo";
}
else if($_SESSION['status']!="Profesor")
echo "Ne mozete da vidite ovaj deo";
else
echo $_SESSION['podaci']."<a href='index.php?odjava'>Odjavite se</a>  <a href='index.php'>Pocetna</a> <a href='prof.php'>Administrativni deo</a>";
?>

<h1>Profesorski servis</h1>
<div>
<div class='opcija'>
    <h3>Brisanje predmeta</h3>
    <select name="predmet" id="predmet">
    <option value="0">--izaberite predmet--</option>
    <?php
        $upit="SELECT * FROM predmeti WHERE idProfesora=".$_SESSION['id'];
        $rez=mysqli_query($db, $upit);
        while($red=mysqli_fetch_object($rez))
            echo "<option value='$red->id'>$red->naziv</option>";
        ?>
    </select> <button type='button' id="brisanje">Obrišite predmet</button><br><br>
    <h3>Dodavanje/Izmena predmeta</h3>
    <input type="text" name="id" id="id" readonly/><br><br>
    <input type="text" name="naziv" id="naziv" placeholder="Unesite naziv"/><br><br>
    <select name="nacinPolaganja" id="nacinPolaganja">
        <option value="0">--izaberite način polaganja--</option>
        <?php
        $upit="SELECT * FROM nacinpolaganja";
        $rez=mysqli_query($db, $upit);
        while($red=mysqli_fetch_object($rez))
            echo "<option value='$red->id'>$red->naziv</option>";
        ?>     
    </select><br><br>
    <input type="date" name="datum" id="datum"/><br><br>
    <button id="dodavanje" type="button">Dodaj/Izmeni predmet</button>
</div>
<div class='opcija'>
    <h3>Logovi</h3>
    <select name="log" id="log">
        <option value="0">--izaberite log--</option>
        <option value="logovanja.txt">Logovanja</option>
        <option value="prijavaispita.txt">Prijava ispita</option>
    </select><br><br>
    <div id='divlogovi'></div>
</div>
<div class='opcija'>
    <h3>Broj prijavljenih studenata</h3>
    <select name="predmetiBroj" id="predmetiBroj">
    <option value="0">Izaberite predmet</option>
    <?php
        $upit="SELECT * FROM predmeti WHERE idProfesora=".$_SESSION['id'];
        $rez=mysqli_query($db, $upit);
        while($red=mysqli_fetch_object($rez))
            echo "<option value='$red->id'>$red->naziv</option>";
        ?>   
    </select><br><br>
    <div id='divbroj'></div>
</div>
</div>
<script>
$("#brisanje").click(function(){
            let a=$("#predmet").val();
            $.post("ajax/ajaxBrisanje.php", {ZaBrisanje: a}, function(response){
                if(response!=1)alert(response);
                else{ 
                alert("Uspesno ste obrisali predmet");
                document.location.assign("prof.php");
                }
            })
        });
$("#log").change(function(){
        let id=$("#log").val();
        if(id=="0")
        {
            $("#divlogovi").html("");
            return false;
        }
        $.post("ajax/ajaxFile.php", {fajl: id}, function(response){ 
            $("#divlogovi").html(response);
        })
    });
$("#predmet").change(function(){
        let predmet=$("#predmet").val();
        if(predmet=="0")
        {
            $("#id").val("");
            $("#naziv").val("");
            $("#nacinPolaganja").val(0);
            $("#datum").val("");
            return false;
        }
        $.post("ajax/ajaxPrikaz.php", {predmet: predmet}, function(response){ 
         let predmet=JSON.parse(response);
         $("#id").val(predmet[0][0]);
         $("#naziv").val(predmet[0][1]);
         $("#nacinPolaganja").val(predmet[0][2]);
         $("#datum").val(predmet[0][3]);
        })
    });
$("#predmetiBroj").change(function(){
        let predmet=$("#predmetiBroj").val();
        if(predmet=="0")
        {
            $("#divbroj").html("");
            return false;
        }
        $.post("ajax/ajaxBroj.php", {predmet: predmet}, function(response){
            $("#divbroj").html("Broj prijavljenih studenata je: ");
            $("#divbroj").append(response);
        })
    });
$("#dodavanje").click(function(){
        let id=$("#id").val();
        let naziv=$("#naziv").val();
        let datum=$("#datum").val();
        let nacinpolaganja=$("#nacinPolaganja").val();
        $.post("ajax/ajaxDodajIzmeni.php", {id:id, naziv:naziv, datum: datum, nacinpolaganja: nacinpolaganja}, function(response){
            if(response==1)alert("Greska");
                else alert(response);
        })
    });
</script>
</body>
</html>