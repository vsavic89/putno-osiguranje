<?php    
    require('layouts/header.php');
    require('./klase/osiguranje.php');    
    require('fpdf/fpdf.php');   
    require('PHPMailer/PHPMailerAutoload.php'); 
    require('funkcije/validacija.php');      

    $ok = true;

    if(!(isset($_POST['ime_prezime']))){
      $ok = false;
      echo '<br />Unesite ime i prezime!';
    }else{
      $ime_prezime = SrediPodatak($_POST['ime_prezime']);      
    }    

    if(!(isset($_POST['datum_rodjenja']))){
      $ok = false;
      echo '<br />Unesite datum rodjenja!';
    }else{
      $datum_rodjenja = SrediPodatak($_POST['datum_rodjenja']);
    }   
    
    if(!(isset($_POST['broj_pasosa']))){
      $ok = false;
      echo '<br />Unesite broj pasosa!';
    }else{
      $broj_pasosa = SrediPodatak($_POST['broj_pasosa']);
    }       

    $telefon = SrediPodatak($_POST['telefon']);

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
      $datum_putovanja_od = SrediPodatak($_POST['datum_putovanja_od']);
    }    

    if(!(isset($_POST['datum_putovanja_do']))){
      $ok = false;
      echo '<br />Unesite datum putovanja do!';
    }else{
      $datum_putovanja_do = SrediPodatak($_POST['datum_putovanja_do']);
    }    

    if(!(isset($_POST['vrsta_polise']))){
      $ok = false;
      echo '<br />Izaberite vrstu polise!';
    }else{
      $vrsta_polise = strtolower(SrediPodatak($_POST['vrsta_polise']));
    }  

    switch($vrsta_polise)
    {
      case 'individualno':
      case 'grupno':
      break;
      default: echo '<br /> Pogresna vrsta polise!';
               $ok = false;
      break;
    }
     
    $dodOsigIP = [];
    $dodOsigBP = [];
    $dodOsigDR = [];    

    if($vrsta_polise === 'grupno')
    {        
        foreach($_POST as $key => $value){                        
             if((strstr($key, "inpIP")) ){
                array_push($dodOsigIP, SrediPodatak($value));                 
             }
             if((strstr($key, "inpBP")) ){
                array_push($dodOsigBP, SrediPodatak($value));                 
             }
             if((strstr($key, "inpDR")) ){
                if (IspravanDatum($value)){
                  if($value > date('Y-m-d')){
                    $ok = false;
                    echo '<br />Datum rodjenja kod dodatnog lica ne moze biti veci od tekuceg datuma!';
                  }else{
                    array_push($dodOsigDR, SrediPodatak($value));                 
                  }
                }else{
                  $ok = false;
                  echo '<br />Datum rodjenja kod dodatnog lica sa vrednoscu: ' . $value . ' nije ispravan!';
                  break;
                }
             }             
        }

        if(sizeof($dodOsigIP) === 0)
        {
            $ok = false;
            echo '<br />Unesite dodatne osiguranike!';            
        }

    }

    if(!IspravanDatum($datum_putovanja_od))
    {
      $ok = false;
      echo '<br />Datum putovanja od nije ispravan!';
    }else{      
      if($datum_putovanja_od < date('Y-m-d')){
        $ok = false;
        echo '<br />Datum putovanja od je manji od tekuceg datuma, to je nedozvoljeno!';
      }
    }

    if(!IspravanDatum($datum_putovanja_do))
    {
      $ok = false;
      echo '<br />Datum putovanja do nije ispravan!';
    }else{
      if($datum_putovanja_od < date('Y-m-d')){
        $ok = false;
        echo '<br />Datum putovanja do je manji od tekuceg datuma, to je nedozvoljeno!';
      }
    }

    if(!IspravanDatum($datum_rodjenja))
    {
      $ok = false;
      echo '<br />Datum rodjenja nije ispravan!';
    }else{
      if($datum_rodjenja > date('Y-m-d')){
        $ok = false;
        echo '<br />Datum rodjenja ne moze biti veci od tekuceg datuma!';
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