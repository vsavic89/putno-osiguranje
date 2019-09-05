<?php    
    require('layouts/header.php');
    require('./klase/osiguranje.php');    
    require('fpdf/fpdf.php');   
    require('PHPMailer/PHPMailerAutoload.php');       

    $ok = true;

    if(!(isset($_POST['ime_prezime']))){
      $ok = false;
      echo '<br />Unesite ime i prezime!';
    }else{
      $ime_prezime = $_POST['ime_prezime'];
    }    

    if(!(isset($_POST['datum_rodjenja']))){
      $ok = false;
      echo '<br />Unesite datum rodjenja!';
    }else{
      $datum_rodjenja = $_POST['datum_rodjenja'];
    }   
    
    if(!(isset($_POST['broj_pasosa']))){
      $ok = false;
      echo '<br />Unesite broj pasosa!';
    }else{
      $broj_pasosa = $_POST['broj_pasosa'];
    }       

    $telefon = $_POST['telefon'];

    if(!(isset($_POST['email']))){
      $ok = false;
      echo '<br />Unesite email!';
    }else{
      $email = $_POST['email'];
      if(!(filter_var($email, FILTER_VALIDATE_EMAIL)))
      {
         echo '<br />Nekorektan e-mail!';
      }
    }     
    
    if(!(isset($_POST['datum_putovanja_od']))){
      $ok = false;
      echo '<br />Unesite datum putovanja od!';
    }else{
      $datum_putovanja_od = $_POST['datum_putovanja_od'];
    }    

    if(!(isset($_POST['datum_putovanja_do']))){
      $ok = false;
      echo '<br />Unesite datum putovanja do!';
    }else{
      $datum_putovanja_do = $_POST['datum_putovanja_do'];
    }    

    if(!(isset($_POST['vrsta_polise']))){
      $ok = false;
      echo '<br />Izaberite vrstu polise!';
    }else{
      $vrsta_polise = $_POST['vrsta_polise'];
    }  
     
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

        if(sizeof($dodOsigIP) === 0)
        {
            echo '<br />Unesite dodatne osiguranike!';
        }

    }

    if($datum_putovanja_od >= $datum_putovanja_do)
    {
       $ok = false;
       echo '<br />Datum putovanja do mora biti veci od datuma putovanja od!';
    }

    if($ok === true)
    {
      $osiguranje = new Osiguranje($ime_prezime, $datum_rodjenja, $broj_pasosa, $telefon, $email, $datum_putovanja_od, $datum_putovanja_do, $vrsta_polise, $dodOsigIP, $dodOsigDR, $dodOsigBP);
      $osiguranje->UnosOsiguranja(); 
    }else{
       echo '<br /><input class="btn btn-danger" type="button" onclick="self.close()" value="Zatvori prozor" />';
    }
?>