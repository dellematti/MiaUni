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
                                        Rimuovi utente</h1>
                                    <br>
                                        <!-- <form method="POST" action="localhost/unimia/scripts/aggiungiUtente.php"> -->
                                        <form method="POST" action="http://localhost/unimia/scripts/segreteria/aggiungiUtente.php">
                                            <div class="form-group" >
                                                <p>Selezionare utente da cancellare (studenti o docenti) : </p>
                                                <input list="utente" name="utente" class="form-control input-lg typeahead top-buffer-s">
                                                    <datalist id="utente" >
                                                        <?php
                                                            require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                                                            $dbConnect = openConnection();
                                                            // $query = "select * from unieuro.get_utenti()";
                                                            $query = "select * from unieuro.get_utenti_non_segreteria()";
                                                            $res = pg_prepare($dbConnect, "", $query);
                                                            $row = pg_fetch_all(pg_execute($dbConnect, "",array() )); // non riceve nessun parametro in ingresso


                                                            foreach($row as $studente) {  
                                                                echo '<option value="',$studente['id_utente'],'">',$studente['nome']." ".$studente['cognome'],'</option>';
                                                            }
                                                        ?>    
                                                    </datalist>
                                                <br>
                                                <button type="submit" class="btn btn-primary btn-lg btn-block">Rimuovi</button>
                                            </div>
                                        </form>
                                </div>
                            </div>    

                    </div>
                </div>

            </div>

    </body>

</html>