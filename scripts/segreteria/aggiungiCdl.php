<?php

session_start();

// print_r($_SESSION);

if (isset($_POST["nome"], $_POST["descrizione"], $_POST["tipoCdl"] )) {  

    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();
   
    // devo generare l id
    $query = " select max(c.id) from unieuro.corsidilaurea c "; 
    $res = pg_prepare($dbConnect, "", $query);
    $row = pg_fetch_all(pg_execute($dbConnect, "", array()));
    $id = $row[0]['max'] + 1 ;
    

    $nomeCdl = strtolower($_POST["nome"]);    
    $magistrale;
    // if ($_POST["tipoCdl"] == 'magistrale') $magistrale = true;
    // else $magistrale = false;
    if ($_POST["tipoCdl"] == 'magistrale') $magistrale = 't';   // pg execute per i booleani non vuole true/false ma 't' 'f'
    else $magistrale = 'f';



    $query = " CALL aggiungere_corso_di_laurea ($1,$2,$3,$4 ); "; 
    $res = pg_prepare($dbConnect, "", $query);
    $row = pg_fetch_all(pg_execute($dbConnect, "", array( $id, $magistrale, $_POST["descrizione"], $nomeCdl)));

}
header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');
?>