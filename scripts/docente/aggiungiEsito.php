<?php
    session_start();
    // dovrei controllare, magari con un trigger, che l esito che sto inserendo non sia già esistente

    // print_r($_SESSION);
    print_r($_POST);

    if (isset($_POST["appello"], $_POST["matricola"], $_POST["esito"] )) { 
        $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
        $query = "INSERT INTO unieuro.studentiesami 
        VALUES ({$_POST["matricola"]}, {$_POST["appello"]}, '{$_POST["esito"]}')";
        $data = $pdo->query($query); 
    }
    header('Location: http://localhost/unimia/sito/docente/homepage_docente.php');
?>