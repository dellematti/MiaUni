<?php
    session_start();
    print_r($_POST);


    if (isset($_POST["nome"], $_POST["anno"], $_POST["cfu"], $_POST["cdl"], $_POST["docente"] )) {  
         
        $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
        $nomeInsegnamento = strtolower($_POST["nome"]);  
        
        $query = "SELECT count(*) AS numero_insegnamento
        FROM unieuro.insegnamenti";
        $data = $pdo->query($query); 
        $idInsegnamento;   
        foreach($data as $row) {    
            $idInsegnamento = $row['numero_insegnamento'] + 1;
        }

        $query = "INSERT INTO unieuro.insegnamenti 
                  VALUES ({$idInsegnamento}, '{$nomeInsegnamento}', {$_POST["anno"]}, {$_POST["cfu"]}, {$_POST["cdl"]},
                         {$_POST["docente"]})";
        $data = $pdo->query($query); 

        // ora vanno messe anche le propedeudicità (in teoria questa sarebbe la seconda transaction)

        foreach($_POST["propedeuticità"] as $propedeuticità) {    
            $query = "INSERT INTO unieuro.propedeuticità 
            VALUES ({$propedeuticità} , {$idInsegnamento} )";
            $data = $pdo->query($query); 
        }

    }
    header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');

?>

