<?php

session_start();

// print_r($_SESSION);
// print_r($_POST);

// da POST mi arrivano l id di insegnamento e la data esame, devo creare l id dell esame e inserire il record
if (isset($_POST["insegnamento"], $_POST["dataEsame"] )) { 

    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
    
    $query = "SELECT count(*) AS numero_appelli
    FROM unieuro.appelli ";
    $data = $pdo->query($query); 
    $idAppello;   
    foreach($data as $row) {     // devo fare ogni volta sta cosa, se so già che ho una row sola?
        $idAppello = $row['numero_appelli'] + 1;
    }


    $query = "INSERT INTO unieuro.appelli 
    VALUES ({$idAppello}, {$_POST["insegnamento"]}, '{$_POST["dataEsame"]}')";

    $data = $pdo->query($query); 

}
header('Location: http://localhost/unimia/sito/docente/homepage_docente.php');

?>