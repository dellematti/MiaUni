
<?php
    session_start();
    print_r($_POST);


    if (isset($_POST["nome"], $_POST["anno"], $_POST["cfu"], $_POST["cdl"], $_POST["docente"] )) {  
        // echo"session";
        // print_r($_SESSION);
        // echo"post";
        // print_r($_POST);
        // echo"<br>propedeuticità";
        // echo$_POST["propedeuticità"];
         
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
        // SOPRA E' GIUSTA, TOGLIERE IL COMMENTO APPENA METTO LA SECONDA PARTE DELLA QUERY

        // ora vanno messe anche le propedeudicità (in teoria questa sarebbe la seconda transaction)


        // print_r($_POST["propedeuticità"]);
        // echo$idInsegnamento;
        // echo"<br>";
        foreach($_POST["propedeuticità"] as $propedeuticità) {    
            // echo$propedeuticità,"<br>";
            $query = "INSERT INTO unieuro.propedeuticità 
            VALUES ({$propedeuticità} , {$idInsegnamento} )";
            $data = $pdo->query($query); 
        }


    
    }
    header('Location: http://localhost/unimia/sito/segreteria/homepage_segreteria.php');


?>



