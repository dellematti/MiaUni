<?php
    session_start();

    print_r($_SESSION);
    print_r($_POST);

    if (isset($_SESSION["matricola"], $_POST["appello"] )) { 
        echo"ciao";
        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
        $dbConnect = openConnection();
                                                
        $query = "CALL iscrizione_appello ( $1, $2)";
        $res = pg_prepare($dbConnect, "", $query);
        $row = pg_fetch_all(pg_execute($dbConnect, "", array($_SESSION["matricola"], $_POST["appello"] )));

    }
    header('Location: http://localhost/unimia/sito/studente/homepage.php');
?>