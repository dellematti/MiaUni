<?php

session_start();


// $pdo = require 'connessioneDatabase.php';
// if ($pdo) {
//     echo "Connected to the database successfully!";
// } 

// print_r($_POST);

if (isset($_POST["nome"], $_POST["cognome"], $_POST["tipoUtente"] )) {   // controllo se ci sono nome e cognome e tipo utente

    // if ($_POST["tipoUtente"] == "studente" && ! isset($_POST["cdl"])  ) {
    if ($_POST["tipoUtente"] == "Studente" && $_POST["cdl"] == "select" ) {  //il campo vuoto sarebbe meglio non sia "select"
        // errore, manca il campo cdl
    }
    if ($_POST["tipoUtente"] == "Docente" && ! isset($_POST["ufficio"])  ) {
        // errore, manca il campo ufficio
    }
    // se l esecuzione non si è fermata prima per gli errori che aggiungerò nelgi if, allora:
    // devo generare i vari id/matricola e l email giusta (devo controllare che non esistano omonimi)


    // sarebbe comodo fare una query e vedere quanti mattia delledonne esistono tra studenti


    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
    
    $query;
    // se l utente è studente allora la query sarà questa
    if ($_POST["tipoUtente"] == "Studente")
        $query = "SELECT count(*) 
        FROM unieuro.studenti AS s
        INNER JOIN unieuro.utenti AS u ON s.utente = u.id
        WHERE u.nome = '{$_POST['nome']}' AND u.cognome = '{$_POST['cognome']}'
        ";
    else if($_POST["tipoUtente"] == "Docente")
        $query = "SELECT count(*) 
        FROM unieuro.docenti AS d
        INNER JOIN unieuro.utenti AS u ON d.utente = u.id
        WHERE u.nome = '{$_POST['nome']}' AND u.cognome = '{$_POST['cognome']}'
        ";

    $data = $pdo->query($query);    
         
    $omonimi;
    foreach($data as $row) {     // avremo nella var omonimi, il numero di omonimi dello stesso tipo utente
        $omonimi = $row['count'];
        // echo"quanti : ",$row['count'], "<br>";
    }

    

    $email = $_POST["nome"] . '.' . $_POST["cognome"];
    if($omonimi != 0) $email = $email . $omonimi;   //se esistono omonimi modifico l email aggiungendo il numero
    if ($_POST["tipoUtente"] == "Studente") $email = $email . "@studente.unimi.it";
    if ($_POST["tipoUtente"] == "Docente") $email = $email . "@docente.unimi.it";

    echo $email;

}



?>