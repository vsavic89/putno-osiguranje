<?php    
    require('osiguranje.php');   
    class Osiguranja
    {
        public function PrikaziOsiguranja()
        {
            $novaKonekcija = new Konekcija();
            $konekcija = $novaKonekcija->KonektujSe();

            $sql = 'select korisnici.ime_prezime, osiguranja.id, osiguranja.datum_upisa from osiguranja inner join korisnici on korisnici.id = osiguranja.korisnici_id';
            $result = $konekcija->query($sql);
            if($result)
            {
                if($result->num_rows > 0){
                    echo '<form class="prikaz" method="POST">';                      
                    echo '<table border="1" width="100%" id="tabelaPrikaz" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>ID osiguranja</th>';
                    echo '<th>Ime i prezime nosioca osiguranja</th>';
                    echo '<th>Datum i vreme upisa</th>';
                    echo '<th>Akcija</th>';
                    echo '</tr>';
                    echo '</thead>';
                    // echo '<tbody>';                                                      
                    while($row=$result->fetch_assoc())
                    {
                        echo '<tr>';
                        echo '<td>'.$row['id'].'</td>';
                        echo '<td>'.$row['ime_prezime'].'</td>';
                        echo '<td>'.$row['datum_upisa'].'</td>';
                        echo '<td><input class="btn btn-primary" type="submit" name="btn_'.$row['id'].'" id="btn_'.$row['id'].'"'.' value="Detaljnije" /></td>';
                        echo '</tr>';
                    }                                                                      
                    // echo '</tbody>';                                              
                    echo '</table>';
                    echo '</form>';                    
                    
                    foreach($_POST as $key => $value){
                        if(strstr($key, "btn_")){                                                                  
                            $osiguranjaID = substr($key, 4);                                                                                                             
                            $osiguranje = new Osiguranje('','','','','','','','',[],[],[]);                        
                            $osiguranje->PrikaziOsiguranje($osiguranjaID);
                            break;
                        }                        
                    }

                }else{
                    echo '<h2>Nema podataka za prikaz.</h2>';
                }
            }

            $konekcija = $novaKonekcija->DiskonektujSe();
        }
    }
?>