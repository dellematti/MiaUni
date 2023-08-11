<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <title>UniEuro</title>

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- ora che l homepage è dentro la cartella, per recuperare il css metto tutto il path -->
    <link href="http://localhost/unimia/css/cssMio.css" rel="stylesheet">
    <!-- <link href="http://localhost/unimia/css/style.css" rel="stylesheet"> -->
    <!-- <link href="http://localhost/unimia/css/cssLogin.css" rel="stylesheet"> -->


</head>


<body >

    <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top "> -->
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top ">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                    <li class="nav-item">
                        <a class="nav-link active" id="uni" aria-current="page" href="/">Uni<span id ="euro">Euro</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- <section class="d-flex"> -->
        <div class="main-content">
            <div class="container pt-4 mt-5">
                <div class="row justify-content-between">
                    <?php
                        session_start();
                        echo "<h2 class=\"top-buffer-s\">",$_SESSION['email'],"</h2>"
                    ?>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 col-lg-offset-4 colonna-centrale"
                                role="main">
                                <h1 class="content-block-title clearfix" id="main-content">
                                    Aggiungi insegnamento</h1>
                                <br>
                                    <!-- <form method="POST" action="localhost/unimia/scripts/aggiungiUtente.php"> -->
                                    <form method="POST" action="http://localhost/unimia/scripts/segreteria/aggiungiInsegnamento.php">
                                        <div class="form-group" >
                                            Inserisci le informazioni necessarie per aggiungere l' insegnamento.
                                            <input id="nome"  class="form-control input-lg typeahead top-buffer-s" name="nome" type="text" class="form-control bg-transparent rounded-0 my-4" placeholder="Nome" 
                                                aria-label="Nome" value="" aria-describedby="basic-addon1">
                                            <br>
                                            <!-- potremmo mettere unn dropdown con 1 2 e 3 (o magari solo 1-2 se magistrale) -->
                                            <input id="anno"  class="form-control input-lg typeahead top-buffer-s" name="anno" type="number" class="form-control bg-transparent rounded-0 my-4" placeholder="anno" 
                                            aria-label="anno" value="" max="3" min="1" aria-describedby="basic-addon1">
                                            <br>
                                            <input id="cfu"  class="form-control input-lg typeahead top-buffer-s" name="cfu" type="number" class="form-control bg-transparent rounded-0 my-4" placeholder="cfu" 
                                            aria-label="cfu" value="" max="180" aria-describedby="basic-addon1">
                                            <br>
                                            <select id="CDL" name="cdl" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="" disabled selected hidden >Selezionare corso di laurea</option>
                                                <?php
                                                    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
                                                    $query = "SELECT c.nome, c.id, c.magistrale 
                                                    FROM unieuro.corsidilaurea AS c";
                                                    $data = $pdo->query($query);    
                                                    
                                                    foreach($data as $row) {  
                                                        if ( $row['magistrale']) 
                                                            echo '<option value="',$row['id'],'">',$row['nome']." - magistrale"."    id: ".$row['id'],'</option>';
                                                        else echo '<option value="',$row['id'],'">',$row['nome']." - triennale"."    id: ".$row['id'],'</option>';
                                                    }
                                                ?>
                                            </select>

                                            <br>
                                            <select id="docente" name="cdl" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="" disabled selected hidden >Selezionare docente</option>

                                                <?php
                                                    // $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php'; // una volta per pagina!
                                                    $query = "SELECT d.utente, u.nome, u.cognome 
                                                    FROM unieuro.docenti AS d
                                                    INNER JOIN unieuro.utenti AS u ON d.utente= u.id";
                                                    $data = $pdo->query($query);    
                                                    foreach($data as $row) {  
                                                        echo'<option value="',$row['utente'],'">',$row['nome']." ".$row['cognome'],'</option>';
                                                    }
                                                ?>
                                                
                                            </select>
                                            <br>

                                            <!-- MANCANO LE PROPEDEUTICITA' -->
                                            <!-- sarà un select ma con valori multipli -->
                                            





                                            
                                            <br>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Aggiungi insegnamento</button>
                                        </div>
                                    </form>
                            </div>
                        </div>    
                </div>
            </div>
        </div>
</body>

</html>