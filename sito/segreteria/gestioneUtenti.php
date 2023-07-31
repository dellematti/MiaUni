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

                        <!-- ORA DEVO TROVARE UN MODO DI AGGIUNGERE RIMUOVERE O MODIFICARE GLI UTENTI -->
                        <!-- metto un cerca utente per rimuoverli o modificarli, e un aggiungi utente -->
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 col-lg-offset-4 colonna-centrale"
                                role="main">
                                <h1 class="content-block-title clearfix" id="main-content">
                                    Aggiungi utente</h1>
                                <br>
                                    <form method="POST" action="aggiungiUtente.php">
                                        <div class="form-group" >
                                            Inserisci le informazioni necessarie ad aggiungere un utente.
                                            <input id="nome"  class="form-control input-lg typeahead top-buffer-s" name="nome" type="text" class="form-control bg-transparent rounded-0 my-4" placeholder="Nome" 
                                                aria-label="Nome" value="" aria-describedby="basic-addon1">
                                            <br>
                                            <input id="cognome"  class="form-control input-lg typeahead top-buffer-s" name="cognome" type="text" class="form-control bg-transparent rounded-0 my-4" placeholder="Cognome" 
                                                aria-label="Cognome" value="" aria-describedby="basic-addon1">
                                            <br>
                                            <select id="tipo" name="tipoUtente" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="select">Seleziona tra studente e docente</option>
                                                <option value="Studente">Studente</option>
                                                <option value="Docente">Docente</option>
                                            </select>
                                            <br>
                                            <select id="CDL" name="cdl" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="select">Se l' utente è uno studente selezionare corso di laurea</option>
                                                <?php
                                                    $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
                                                    $query = "SELECT c.nome, c.id 
                                                    FROM unieuro.corsidilaurea AS c";
                                                    $data = $pdo->query($query);    
                                                    
                                                    foreach($data as $row) {   
                                                        echo '<option value="',$row['id'],'">',$row['nome'],'</option>';
                                                    }
                                                ?>

                                            </select>
                                            <br>
                                            <input id="ufficio"  class="form-control input-lg typeahead top-buffer-s" name="ufficio" type="text" 
                                                class="form-control bg-transparent rounded-0 my-4" placeholder="Se l'utente è un docente, inserire l'indirizzo dell' ufficio" 
                                                aria-label="Ufficio" value="" aria-describedby="basic-addon1">
                                            <br>
                                            


                                            <!-- la password e l email verranno generate per ogni utente da uno script 
                                                stessa cosa per l id, e per la matricola dello studente -->


                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Aggiungi</button>
                                        </div>
                                    </form>
                            </div>
                        </div>    



                </div>
            </div>

        </div>

</body>

</html>