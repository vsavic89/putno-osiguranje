<?php    
    require('layouts/header.php');
    require('./klase/osiguranje.php');    
    require('fpdf/fpdf.php');   
    require('PHPMailer/PHPMailerAutoload.php');       

    $ime_prezime = $_POST['ime_prezime'];
    $datum_rodjenja = $_POST['datum_rodjenja'];
    $broj_pasosa = $_POST['broj_pasosa'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $datum_putovanja_od = $_POST['datum_putovanja_od'];
    $datum_putovanja_do = $_POST['datum_putovanja_do'];
    $vrsta_polise = $_POST['vrsta_polise'];    
    $dodOsigIP = [];
    $dodOsigBP = [];
    $dodOsigDR = [];
    if($vrsta_polise === 'grupno')
    {        
        foreach($_POST as $key => $value){                        
             if((strstr($key, "inpIP")) ){
                array_push($dodOsigIP, $value);                 
             }
             if((strstr($key, "inpBP")) ){
                array_push($dodOsigBP, $value);                 
             }
             if((strstr($key, "inpDR")) ){
                array_push($dodOsigDR, $value);                 
             }             
        }
    }

    $osiguranje = new Osiguranje($ime_prezime, $datum_rodjenja, $broj_pasosa, $telefon, $email, $datum_putovanja_od, $datum_putovanja_do, $vrsta_polise, $dodOsigIP, $dodOsigDR, $dodOsigBP);
    $osiguranje->UnosOsiguranja();    
?>