<?php
    session_start();
    // dovrei controllare, magari con un trigger, che l esito che sto inserendo non sia già esistente

    // print_r($_SESSION);
    // print_r($_POST);

    if (isset($_POST["appello"], $_POST["matricola"], $_POST["esito"] )) { 
        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
        require 'C:\xampp\htdocs\unimia\scripts\erroreMessaggio.php';
        $dbConnect = openConnection();

        // se la matricola non è iscritta all appello, allora devo dare un messaggio di errore
        $query = "SELECT * FROM unieuro.iscrizione_appello_presente($1, $2)";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST["matricola"], $_POST["appello"] )));

        $iscrizionePresente = $row[0]["iscrizione_appello_presente"] === 'f'? false: true;   // sarebbe meglio altro
        // echo $iscrizionePresente ? 'true' : 'false';

        if (! $iscrizionePresente) { // errore
            messaggio("Errore: studente non iscritto all appello", "http://localhost/unimia/sito/docente/gestioneEsiti.php");
            return;
        }

        // dovrei controllare anche che non abbia già un voto

        
        $query = "SELECT * FROM unieuro.voto_appello_presente($1, $2)";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST["matricola"], $_POST["appello"] )));
        $votoPresente = $row[0]["voto_appello_presente"] === 'f'? false: true;   // sarebbe meglio altro
        // echo $votoPresente ? 'true' : 'false';

        if ( $votoPresente) { // errore voto già presente
            messaggio("Errore: voto già presente", "http://localhost/unimia/sito/docente/gestioneEsiti.php");
            return;
        }


        // ora che ho controllato posso inserire
        $query = "CALL inserire_voto ( $1, $2, $3)";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST["matricola"], $_POST["appello"],  $_POST["esito"]  )));

    }
    header('Location: http://localhost/unimia/sito/docente/homepage_docente.php');
?>