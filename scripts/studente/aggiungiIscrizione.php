<?php
    session_start();

    print_r($_SESSION);
    print_r($_POST);

    // controllo che l utente non abbia messo sia un esame del suo cdl sia uno di un altro cdl
    if (isset($_SESSION["matricola"], $_POST["appello"]  ) xor isset($_SESSION["matricola"], $_POST["appelliNonCDL"]  ) ) { 
        echo"ciao";
        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
        $dbConnect = openConnection();
                                                
        $query = "CALL iscrizione_appello ( $1, $2)";
        $res = pg_prepare($dbConnect, "", $query);
        if (isset($_POST["appello"]))
            $row = pg_fetch_all(pg_execute($dbConnect, "", array($_SESSION["matricola"], $_POST["appello"] )));
        else 
            $row = pg_fetch_all(pg_execute($dbConnect, "", array($_SESSION["matricola"], $_POST["appelliNonCDL"] )));


    }
    header('Location: http://localhost/unimia/sito/studente/homepage.php');
?>