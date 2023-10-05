<?php

session_start();


if (isset($_POST["nome"], $_POST["cognome"], $_POST["tipoUtente"] )) {   // controllo se ci sono nome e cognome e tipo utente

    if ($_POST["tipoUtente"] == "Studente" && $_POST["cdl"] == "select" ) { 
        // errore, manca il campo cdl
    }
    if ($_POST["tipoUtente"] == "Docente" && ! isset($_POST["ufficio"])  ) {
        // errore, manca il campo ufficio
    }

    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();
    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';


    $query;
    $res;
    $row;
    if ($_POST["tipoUtente"] == "Studente") {
        $query = "SELECT count(*) 
        FROM unieuro.studenti AS s
        INNER JOIN unieuro.utenti AS u ON s.utente = u.id
        WHERE u.nome = '$1' AND u.cognome = '$2'";

        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST['nome'], $_POST['cognome'])));
    } else if($_POST["tipoUtente"] == "Docente") {
        $query = "SELECT count(*) 
        FROM unieuro.docenti AS d
        INNER JOIN unieuro.utenti AS u ON d.utente = u.id
        WHERE u.nome = '$1' AND u.cognome = '$2'";

        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST['nome'], $_POST['cognome'])));
}



    $omonimi;
    foreach($row as $utente) {     // avremo nella var omonimi, il numero di omonimi dello stesso tipo utente
        $omonimi = $utente['count'];
        // echo"quanti : ",$row['count'], "<br>";
    }

    $nomeUtente = strtolower($_POST["nome"]);    
    $cognomeUtente = strtolower($_POST["cognome"]);    

    $email = $nomeUtente . '.' . $cognomeUtente;
    if($omonimi != 0) $email = $email . $omonimi;   //se esistono omonimi modifico l email aggiungendo il numero
    if ($_POST["tipoUtente"] == "Studente") $email = $email . "@studenti.unimi.it";
    if ($_POST["tipoUtente"] == "Docente") $email = $email . "@docenti.unimi.it";
    if ($_POST["tipoUtente"] == "Segreteria") $email = $email . "@segreteria.unimi.it";
    
    $password = 'password';
 
    // ora ho nome cognome email e password (la password potrei generla casualmente, per comodità saranno tutte 'password)


    $query = "SELECT count(*) AS numero_utenti
    FROM unieuro.utenti ";
    $data = $pdo->query($query); 
    $idUtente;   
    foreach($data as $row) {    
        $idUtente = $row['numero_utenti'] + 1;
    }

    echo$idUtente,"<br>";
    echo $email,"<br>";
    echo $password,"<br>";
    echo$_POST["nome"],"<br>"; 
    echo$_POST["cognome"],"<br><br>";


    if ($_POST["tipoUtente"] == "Studente") {
        $query = "SELECT * FROM unieuro.get_prossima_matricola();";
        $data = $pdo->query($query); 
        $matricola;   
        foreach($data as $row) {    
            $matricola = $row['matricola'];
        }
        

        $query = "INSERT INTO unieuro.utenti 
        VALUES ({$idUtente}, '{$email}', '{$password}', '{$nomeUtente}', '{$cognomeUtente}')";
        $data = $pdo->query($query); 

        // $query = "CALL cancella_utente ( $1 );";
        // $res = pg_prepare($dbConnect, "", $query);
        // $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente)));
       



        $query = "INSERT INTO unieuro.studenti 
        VALUES ({$matricola}, {$_POST['cdl']}, {$idUtente})";
        $data = $pdo->query($query); 
    }

    if ($_POST["tipoUtente"] == "Docente") {
        echo$idUtente,"<br>";
        echo$_POST["ufficio"],"<br>";
        
        $query = "INSERT INTO unieuro.utenti 
        VALUES ({$idUtente}, '{$email}', '{$password}', '{$nomeUtente}', '{$cognomeUtente}')";
        $data = $pdo->query($query); 
        $query = "INSERT INTO unieuro.docenti 
        VALUES ({$idUtente}, '{$_POST["ufficio"]}' )";
        $data = $pdo->query($query); 
    }

    if ($_POST["tipoUtente"] == "Segreteria") {
        echo$idUtente,"<br>";
        echo$_POST["ufficio"],"<br>";
        
        $query = "INSERT INTO unieuro.utenti 
        VALUES ({$idUtente}, '{$email}', '{$password}', '{$nomeUtente}', '{$cognomeUtente}')";
        $data = $pdo->query($query); 
        $query = "INSERT INTO unieuro.segreteria 
        VALUES ({$idUtente}, '{$_POST["ufficio"]}' )";
        $data = $pdo->query($query); 
    }



}

header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');


?>