<!-- devo vedere quali attributi mi sono arrivati e fare l update di quelli -->

<?php

// session_start();
print_r($_POST);


if ( isset($_POST["utente"]) && (isset($_POST["nome"]) || isset($_POST["cognome"]) || isset($_POST["email"]) || isset($_POST["password"])  ) ) {   

    echo'dentro l if';
    session_start();
    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();


    // if ( isset($_POST["nome"]) ) {
    if ( $_POST["nome"] != '' ) {
        echo'dentro il secondo if';
        $query = "CALL aggiorna_nome ($1, $2 )";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "",array($_POST["utente"], $_POST["nome"]) )); 
    }
    // if ( isset($_POST["cognome"]) ) {
    if ( $_POST["cognome"] != '' ) {
        $query = "CALL aggiorna_cognome ($1, $2 )";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "",array($_POST["utente"], $_POST["cognome"]) )); 
    }
    // if ( isset($_POST["email"]) ) {
    if ( $_POST["email"] != '' ) {
        echo'dentro l if email';
        $query = "CALL aggiorna_email ($1, $2 )";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "",array($_POST["utente"], $_POST["email"]) )); 
    }
    // if ( isset($_POST["password"]) ) {
    if ( $_POST["password"] != '' ) {
        $query = "CALL aggiorna_password ($1, $2 )";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "",array($_POST["utente"], $_POST["password"]) )); 
    }
}
header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');

?>