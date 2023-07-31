<?php

session_start();


$pdo = require 'connessioneDatabase.php';
if ($pdo) {
    echo "Connected to the database successfully!";
} 

print_r($_POST);

if (isset($_POST["nome"], $_POST["cognome"], $_POST["tipoUtente"] )) {   // controllo se ci sono nome e cognome e tipo utente

    // ora devo controllare che se è studente ci sia il corso di laurea, e che se è docente ci sia l ufficio
    // poi devo generare i vari id/matricola e l email giusta (devo controllare che non esistano omonimi)



}



?>