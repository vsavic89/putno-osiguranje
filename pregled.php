<?php
    require('layouts/header.php');    
    require('./klase/osiguranja.php');
?>

<h1>Pregled polisa</h1>
<div id="container">
    <?php
        $osiguranja = new Osiguranja();
        $osiguranja->PrikaziOsiguranja();
    ?>
</div>

<?php
    require('layouts/footer.php');
?>