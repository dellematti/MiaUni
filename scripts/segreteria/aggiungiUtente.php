<?php

session_start();


if (isset($_POST["nome"], $_POST["cognome"], $_POST["tipoUtente"] )) {   // controllo se ci sono nome e cognome e tipo utente

    // if ($_POST["tipoUtente"] == "studente" && ! isset($_POST["cdl"])  ) {
    if ($_POST["tipoUtente"] == "Studente" && $_POST["cdl"] == "select" ) {  //il campo vuoto sarebbe meglio non sia "select"
        // errore, manca il campo cdl
    }
    if ($_POST["tipoUtente"] == "Docente" && ! isset($_POST["ufficio"])  ) {
        // errore, manca il campo ufficio
    }
    // se l esecuzione non si è fermata prima per gli errori che aggiungerò nelgi if, allora:

    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
    
    $query;
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

    $nomeUtente = strtolower($_POST["nome"]);    
    $cognomeUtente = strtolower($_POST["cognome"]);    

    $email = $nomeUtente . '.' . $cognomeUtente;
    if($omonimi != 0) $email = $email . $omonimi;   //se esistono omonimi modifico l email aggiungendo il numero
    if ($_POST["tipoUtente"] == "Studente") $email = $email . "@studenti.unimi.it";
    if ($_POST["tipoUtente"] == "Docente") $email = $email . "@docenti.unimi.it";
    
    $password = 'password';
 
    // ora ho nome cognome email e password (la password potrei generla casualmente, per comodità saranno tutte 'password)
    // per sapere l id utente dovrò fare un count di utenti, stessa cosa per la matricola se l utente è studente


    $query = "SELECT count(*) AS numero_utenti
    FROM unieuro.utenti ";
    $data = $pdo->query($query); 
    $idUtente;   
    foreach($data as $row) {     // devo fare ogni volta sta cosa, se so già che ho una row sola?
        $idUtente = $row['numero_utenti'] + 1;
    }

    echo$idUtente,"<br>";
    echo $email,"<br>";
    echo $password,"<br>";
    echo$_POST["nome"],"<br>"; 
    echo$_POST["cognome"],"<br><br>";


    if ($_POST["tipoUtente"] == "Studente") {
        $query = "SELECT count(*) 
        FROM unieuro.studenti ";
        $data = $pdo->query($query); 
        $matricola;   
        foreach($data as $row) {     // devo fare ogni volta sta cosa, se so già che ho una row sola?
            $matricola = $row['count'] + 1;
        }
        echo$matricola,"<br>";
        echo$_POST["cdl"],"<br>";
        echo$idUtente,"<br>";

        // ANDREBBE FATTO CON UNA TRANSACTION !!!
        $query = "INSERT INTO unieuro.utenti 
        VALUES ({$idUtente}, '{$email}', '{$password}', '{$nomeUtente}', '{$cognomeUtente}')";
        $data = $pdo->query($query); 

        $query = "INSERT INTO unieuro.studenti 
        VALUES ({$matricola}, {$_POST['cdl']}, {$idUtente})";
        $data = $pdo->query($query); 
    }

    if ($_POST["tipoUtente"] == "Docente") {
        echo$idUtente,"<br>";
        echo$_POST["ufficio"],"<br>";
        
        // anche qua servirebbe una transaction
        $query = "INSERT INTO unieuro.utenti 
        VALUES ({$idUtente}, '{$email}', '{$password}', '{$nomeUtente}', '{$cognomeUtente}')";
        $data = $pdo->query($query); 
        $query = "INSERT INTO unieuro.docenti 
        VALUES ({$idUtente}, '{$_POST["ufficio"]}' )";
        $data = $pdo->query($query); 
    }

    // dovrò fare in modo di poter aggiungere anche utenti della segreteria


}

header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');


?>