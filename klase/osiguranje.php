<?php           
    class Osiguranje
    {        
        private $imePrezime;        
        private $datumRodjenja;
        private $brojPasosa;
        private $telefon;
        private $email;
        private $datumPutovanjaOd;
        private $datumPutovanjaDo;
        private $vrstaPolise;

        private $dodOsigIP;
        private $dodOsigDR;
        private $dodOsigBP;
        
        public function __construct(
            $imePrezime, $datumRodjenja, $brojPasosa, $telefon, $email, $datumPutovanjaOd, $datumPutovanjaDo, $vrstaPolise, 
            $dodOsigIP, $dodOsigDR, $dodOsigBP
        )
        {
            $this->imePrezime = $imePrezime;            
            $this->datumRodjenja = $datumRodjenja;
            $this->brojPasosa = $brojPasosa;
            $this->telefon = $telefon;
            $this->email = $email;
            $this->datumPutovanjaOd = $datumPutovanjaOd;
            $this->datumPutovanjaDo = $datumPutovanjaDo;
            $this->vrstaPolise = strtolower($vrstaPolise);
            $this->dodOsigIP = $dodOsigIP;
            $this->dodOsigDR = $dodOsigDR;
            $this->dodOsigBP = $dodOsigBP;
        }

        private function PosaljiPDF()
        {            
            $mail = new PHPMailer;  //koristi se stabilna verzija PHPMailer-a 5.2!
            
            $mail->IsSMTP();
            $mail->Host = "smtp.mailtrap.io";        
            $mail->SMTPAuth = true;
            $mail->Username = 'efe9d74cbd7dc6';
            $mail->Password = 'c89f96f5de3543';
            
                            
            $mail->setFrom = "ja@mojdomen.com";            

            $mail->addAddress($this->email);
            
            $mail->addAttachment("prijava.pdf");                    

            $mail->isHTML(true);

            $mail->Subject = "Izvestaj o prijavi putnog osiguranja";
            $mail->Body = "<i>Dokument se nalazi u prilogu ovog mail-a.</i>";            

            if(!$mail->send()) 
            {
                echo "Mailer greska: " . $mail->ErrorInfo;
            } 
            else 
            {
                echo "Poruka je uspesno poslata!";
            }
        }

        private function NapraviPDF()
        {
            $pdf = new FPDF();
            $pdf->AddPage();    
            $pdf->SetFont('Arial','B',14);            
            $pdf->Cell(40,10, 'Izvestaj o prijavi putnog osiguranja');        
            $pdf->SetFont('Arial', '', 9);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Ime i prezime: ' . $this->imePrezime);            
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Datum rodjenja: ' . $this->datumRodjenja);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Broj pasosa: ' . $this->brojPasosa);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Telefon: ' . $this->telefon);
            $pdf->Ln();                        
            $pdf->Cell(40,10, 'E-mail adresa: ' . $this->email);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Datum putovanja od: ' . $this->datumPutovanjaOd);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Datum putovanja do: ' . $this->datumPutovanjaDo);
            $pdf->Ln();            
            $pdf->Cell(40,10, 'Vrsta polise osiguranja: ' . $this->vrstaPolise);
            if($this->vrstaPolise === 'grupno')
            {
                $pdf->Ln();            
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(40,10, 'Dodatna lica na polisi');
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(40,10,'Ime i prezime');
                $pdf->Cell(40,10,'Datum rodjenja');
                $pdf->Cell(40,10,'Broj pasosa');                    
                $pdf->SetFont('Arial', '', 9);
                for($i=0;$i<sizeof($this->dodOsigIP);$i++)
                {
                    $pdf->Ln();            
                    $pdf->Cell(40,10, $this->dodOsigIP[$i]);
                    $pdf->Cell(40,10, $this->dodOsigDR[$i]);
                    $pdf->Cell(40,10, $this->dodOsigBP[$i]);
                }
            }
            $pdf->Output('F', 'prijava.pdf');
        }

        public function UnosOsiguranja()
        {                                    
            $novaKonekcija = new Konekcija();
            $konekcija = $novaKonekcija->KonektujSe();

            SrediPodatakZaBazu($konekcija, $this->imePrezime);
            SrediPodatakZaBazu($konekcija, $this->datumRodjenja);
            SrediPodatakZaBazu($konekcija, $this->brojPasosa);    
            SrediPodatakZaBazu($konekcija, $this->telefon);
            SrediPodatakZaBazu($konekcija, $this->email);
            SrediPodatakZaBazu($konekcija, $this->datumPutovanjaOd);
            SrediPodatakZaBazu($konekcija, $this->datumPutovanjaDo);
            SrediPodatakZaBazu($konekcija, $this->vrstaPolise);        

            $sql = "insert into korisnici(ime_prezime,datum_rodjenja,broj_pasosa) 
                values ('".$this->imePrezime."', '".$this->datumRodjenja."', '".$this->brojPasosa."')";                    

            if($konekcija->query($sql))
            {                                
                $korisniciId = $konekcija->insert_id;                                                
                $sql = "select id from vrste_polisa where lower(naziv) like '$this->vrstaPolise'";
                $result = $konekcija->query($sql);
                if($result->num_rows > 0)
                {                    
                    $row=$result->fetch_assoc();   
                    $vrstaPoliseID = $row['id'];                                     
                    $sql = "insert into osiguranja(telefon, email, datum_putovanja_od, datum_putovanja_do, datum_upisa, vrste_polisa_id, korisnici_id)
                        values ('$this->telefon', '$this->email', '$this->datumPutovanjaOd', '$this->datumPutovanjaDo', NOW(), '$vrstaPoliseID', '$korisniciId')";
                    $konekcija->query($sql);  
                    $osiguranjeID = $konekcija->insert_id;
                    if($this->vrstaPolise === 'grupno')
                    {
                        for($i=0;$i<sizeof($this->dodOsigIP);$i++)
                        {
                            $sql = "insert into korisnici(ime_prezime,datum_rodjenja,broj_pasosa) 
                                values ('".SrediPodatakZaBazu($konekcija, $this->dodOsigIP[$i])."', '".SrediPodatakZaBazu($konekcija, $this->dodOsigDR[$i])."', '".SrediPodatakZaBazu($konekcija, $this->dodOsigBP[$i])."')";                    
                            $konekcija->query($sql);
                            $korisniciId = $konekcija->insert_id;

                            $sql = "insert into osiguranici(osiguranja_id,korisnici_id) values ('$osiguranjeID', '$korisniciId')";
                            $konekcija->query($sql);
                        }
                    }

                }                          
            }
            $konekcija = $novaKonekcija->DiskonektujSe();

            $this->NapraviPDF();       
             $this->PosaljiPDF();

            header('Location: pregled.php');
            exit();
        }
        public function PrikaziOsiguranje($osiguranjaID)
        {
            $novaKonekcija = new Konekcija();
            $konekcija = $novaKonekcija->KonektujSe();            

            $sql = "select osiguranja.id, osiguranja.datum_upisa,korisnici.ime_prezime,korisnici.datum_rodjenja,korisnici.broj_pasosa,
                osiguranja.telefon,osiguranja.email,osiguranja.datum_putovanja_od, osiguranja.datum_putovanja_do, vrste_polisa.naziv, 
                date(datum_putovanja_do) - date(datum_putovanja_od) as brojDana from osiguranja inner join korisnici on korisnici.id=osiguranja.korisnici_id inner join vrste_polisa on vrste_polisa.id = osiguranja.vrste_polisa_id where osiguranja.id = '$osiguranjaID'";

            $result = $konekcija->query($sql);

            if($result->num_rows > 0)
            {                
                echo '<h1>Dodatne informacije (pojedinacni osiguranik)</h1>';
                echo '<div style="text-align:center;">';
                while($row = $result->fetch_assoc())
                {
                    echo '<p>ID osiguranja: <strong>' . $row['id'].'</strong></p>';
                    echo '<p>Datum i vreme upisa: <strong>' . $row['datum_upisa'].'</strong></p>';
                    echo '<p>Ime i prezime: <strong>' . $row['ime_prezime'].'</strong></p>';
                    echo '<p>Datum rodjenja: <strong>' . $row['datum_rodjenja'].'</strong></p>';
                    echo '<p>Broj pasosa: <strong>' . $row['broj_pasosa'].'</strong></p>';
                    echo '<p>Telefon: <strong>' . $row['telefon'].'</strong></p>';
                    echo '<p>E-mail: <strong>' . $row['email'].'</strong></p>';
                    echo '<p>Datum putovanja od: <strong>' . $row['datum_putovanja_od'].'</strong></p>';
                    echo '<p>Datum putovanja do: <strong>' . $row['datum_putovanja_do'].'</strong></p>';
                    echo '<p>Broj dana: <strong>' . $row['brojDana'] . '</strong></p>';
                    echo '<p>Vrsta polise osiguranja: <strong>' . $row['naziv'].'</strong></p>';
                    if($row['naziv'] === 'grupno')
                    {
                        echo '<input class="btn btn-secondary" type="button" onclick="prikaziSakriDodatnaLica()" value="Prikazi dodatna lica na polisi" id="btnDodatnaLica"/>'; 
                        $sql = "select korisnici.ime_prezime, korisnici.datum_rodjenja, korisnici.broj_pasosa from osiguranici inner join osiguranja on osiguranja.id = osiguranici.osiguranja_id 
                            inner join korisnici on korisnici.id = osiguranici.korisnici_id where osiguranja_id = '$osiguranjaID'";

                        $result = $konekcija->query($sql);
                        if($result->num_rows > 0)
                        {
                            echo '<div hidden id="dodatnaLica">';
                            echo '<h4>Dodatna lica na polisi</h4>';
                            echo '<table border="1" width="100%">';
                            echo '<tr>';
                            echo '<th>Ime i prezime</th>';
                            echo '<th>Datum rodjenja</th>';
                            echo '<th>Broj pasosa</th>';
                            echo '</tr>';
                            while($row = $result->fetch_assoc())
                            {
                                echo '<tr>';
                                echo '<td>' . $row['ime_prezime'] . '</td>';
                                echo '<td>' . $row['datum_rodjenja'] . '</td>';
                                echo '<td>' . $row['broj_pasosa'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';
                            echo '</div>';
                        }
                        
                    }
                }     
                echo '</div>';           
            }

            $konekcija = $novaKonekcija->DiskonektujSe();
        }
    }
?>