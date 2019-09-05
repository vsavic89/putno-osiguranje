<?php   
    class VrstePolisa 
    {
        public function IzlistajListePolisa()
        {
            $novaKonekcija = new Konekcija();
            $konekcija = $novaKonekcija->KonektujSe();

            $sql = 'select naziv from vrste_polisa order by id';
            $result = $konekcija->query($sql);

            if($result->num_rows > 0)
            {
                echo '<select name="vrsta_polise" id="vrsta_polise" onchange="IzabranaPolisa()">';
                while($row=$result->fetch_assoc())
                {
                    echo '<option>'. $row['naziv'] .'</option>';
                }
                echo '</select>';
            }

            $konekcija = $novaKonekcija->DiskonektujSe();    

        }
    }
?>