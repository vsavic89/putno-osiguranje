<?php
    function SrediPodatak($vrednost)
    {
        $zabranjeniKarakteri = array('{','}','[',']','(',')',';',':','<','>','/','$', '"', "'", '?', '!', ',', '.','~','`','^','%','#','*', '&','_','+','=','/','\\','|');
        $vrednost = str_ireplace($zabranjeniKarakteri, "", $vrednost);
        $vrednost = strip_tags($vrednost);
        $vrednost = htmlentities($vrednost);
        if(get_magic_quotes_gpc())
        {
            $vrednost = stripslashes($vrednost);
        }

        return $vrednost;
    }
    function SrediPodatakZaBazu($konekcija, $vrednost)
    {
        $vrednost = mysqli_real_escape_string($konekcija, $vrednost);

        return $vrednost;
    }
    function IspravanDatum($datum)
    {
        $niz = explode('-', $datum);            

        return checkdate($niz[1], $niz[2], $niz[0]);          
    }
?>