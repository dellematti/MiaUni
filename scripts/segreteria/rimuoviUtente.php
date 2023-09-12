<?php

session_start();

print_r($_POST);

if (isset($_POST["utente"])) {  

    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();
    
    
    $idUtente = $_POST["utente"] ;
    $query = "CALL cancella_utente ( $1 );";
    $res = pg_prepare($dbConnect, "", $query);
    $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente)));
   
    foreach($row as $appello) {  
        if ( $appello['magistrale'] === true) 
            echo '<option value="', $appello['appello_id'],'">',$appello['nome']."   - CDL: "." - magistrale"."   - Data: ".$appello['giorno'],'</option>';
        else echo '<option value="', $appello['appello_id'],'">',$appello['nome']."   - CDL: "." - triennale"."   - Data: ".$appello['giorno'],'</option>';
    }
}
header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');
?>