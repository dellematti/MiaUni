<?php
    session_start();
    // dovrei controllare, magari con un trigger, che l esito che sto inserendo non sia già esistente

    // print_r($_SESSION);
    print_r($_POST);

    if (isset($_POST["appello"], $_POST["matricola"], $_POST["esito"] )) { 
        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
        $dbConnect = openConnection();
                                                
        $query = "CALL inserire_voto ( $1, $2, $3)";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_POST["matricola"], $_POST["appello"],  $_POST["esito"]  )));

    }
    header('Location: http://localhost/unimia/sito/docente/homepage_docente.php');
?>