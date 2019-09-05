<?php
    require('layouts/header.php');
    require('./klase/vrste_polisa.php'); 
?>
    
    <h1>
        Prijava za putno osiguranje 
    </h1>   
    <form action="upisi_osiguranje.php" method="POST" target="_blank"> 
        <div class="container">    
            <div class="form-group">
                <label for="ime_prezime">Ime i prezime: </label>
                <input type="text" name="ime_prezime" class="form-control" required />                
                <label for="datum_rodjenja">Datum rodjenja: </label>
                <input type="date" name="datum_rodjenja" class="form-control" required />
                <label for="broj_pasosa">Broj pasosa: </label>
                <input type="text" name="broj_pasosa" class="form-control" required />
                <label for="telefon">Telefon: </label>
                <input type="text" name="telefon" class="form-control"  />
                <label for="email">E-mail: </label>
                <input type="email" name="email" class="form-control" required />
                <label for="datum_putovanja_od">Datum putovanja od: </label>
                <input type="date" name="datum_putovanja_od" class="form-control" required id="datumPutovanjaOd" onchange="IzracunajBrojDana()"/>
                <label for="datum_putovanja_do">Datum putovanja do: </label>
                <input type="date" name="datum_putovanja_do" class="form-control" required id="datumPutovanjaDo" onchange="IzracunajBrojDana()"/>
                <p id="brojDana"></p>
                <label for="vrsta_polise">Vrsta polise osiguranja: </label>
                <?php          
                    $lp = new VrstePolisa();           
                    $lp->IzlistajListePolisa();
                ?>      
                <div id="dodatniOsiguranici"></div>  
                <br />                              
                <input type="submit" class="btn btn-primary" value="Upisi osiguranje" /> 
            </div>
        </div>
    </form>    
<?php
    require('layouts/footer.php');
?>