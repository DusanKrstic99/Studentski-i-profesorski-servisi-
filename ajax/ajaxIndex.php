<?php
session_start();
require_once("../funkcije.php");
$db=konekcija();
if(isset($_POST['korime']) and isset($_POST['lozinka']))
{
    $korime=$_POST['korime'];
    $lozinka=$_POST['lozinka'];
    if($korime!="" and $lozinka!="")
    {
        $upit="SELECT * FROM korisnici WHERE korime='{$korime}'";
        $rez=mysqli_query($db, $upit);
        if(mysqli_num_rows($rez)>0)
        {
            $red=mysqli_fetch_object($rez);
            if($lozinka==$red->lozinka)
            {
                $_SESSION['id']=$red->id;
                $_SESSION['podaci']="$red->ime $red->prezime ($red->status)";
                $_SESSION['status']=$red->status;
                upisiLog("../logovi/logovanja.txt", "Prijava korisnika {$_SESSION['podaci']}");
                echo 1;
            }
            else{
            upisiLog("../logovi/logovanja.txt", "Lozinka za korisnika $korime nije dobra!!!");
                echo "Lozinka za korisnika $korime nije dobra!!!";
            }  
        }
        else{
        upisiLog("../logovi/logovanja.txt", "Ne postoji korisnik sa korisničkim imenom $korime");
            echo "Ne postoji korisnik sa korisničkim imenom $korime";
        }  

    }
    else{
    upisiLog("../logovi/logovanja.txt", "Podaci nisu uneti");
        echo "Podaci nisu uneti";
    }
}
else{
upisiLog("../logovi/logovanja.txt", "Ne postoje podaci");
    echo "Ne postoje podaci";
}
?>