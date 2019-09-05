<?php
    class Konekcija
    {
        private $imeHosta = 'localhost';
        private $imeBaze = 'putno_osiguranje';
        private $imeKorisnika = 'root';
        private $lozinka = 'root';
        private $konekcija;        

        public function KonektujSe()
        {
            $this->konekcija = new mysqli($this->imeHosta, $this->imeKorisnika, $this->lozinka, $this->imeBaze) or die("Greska pri konektovanju: %s\n". $this->konekcija -> error);
 
            return $this->konekcija;
        }
        public function DiskonektujSe()
        {
            $this->konekcija->close();
        }
    }
?>