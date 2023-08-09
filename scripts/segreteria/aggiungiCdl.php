<?php

session_start();

// print_r($_POST);

if (isset($_POST["nome"], $_POST["descrizione"], $_POST["tipoCdl"] )) {   // controllo se ci sono nome e cognome e tipo utente

    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
    
    $nomeCdl = strtolower($_POST["nome"]);    

    $query = "SELECT count(*) AS numero_cdl
    FROM unieuro.corsidilaurea ";
    $data = $pdo->query($query); 
    $idCdl;   
    foreach($data as $row) {     // devo fare ogni volta sta cosa, se so già che ho una row sola?
        $idCdl = $row['numero_cdl'] + 1;
    }

    $magistrale;
    if ($_POST["tipoCdl"] == 'magistrale') $magistrale = TRUE;
    else $magistrale = FALSE;


    // prima di mettere il cdl, potrei controllare che non esista già un corso con lo stesso nome (o potrei modificare il db per
    // mettere anche il nome e il boolean magistrale come chiave della tabella cdl)

    if ( $magistrale) 
        $query = "INSERT INTO unieuro.corsidilaurea 
        VALUES ({$idCdl}, true, '{$_POST["descrizione"]}', '{$nomeCdl}')";
    else 
        $query = "INSERT INTO unieuro.corsidilaurea 
        VALUES ({$idCdl}, false, '{$_POST["descrizione"]}', '{$nomeCdl}')";

    $data = $pdo->query($query); 

}
header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');

?>