<!DOCTYPE html>
<html>


    <head>

        <meta charset="utf-8">
        <title>UniEuro</title>

        <!-- Main Stylesheet -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link href="http://localhost/unimia/css/cssMio.css" rel="stylesheet">
        <!-- <link href="http://localhost/unimia/css/style.css" rel="stylesheet"> -->
        <!-- <link href="http://localhost/unimia/css/cssLogin.css" rel="stylesheet"> -->


    </head>

    <body>
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

    <div class="main-content">
            <div class="container pt-4 mt-5">
                <div class="row justify-content-between">
                    <?php
                        session_start();
                        echo "<h2 class=\"top-buffer-s\">",$_SESSION['email'],"</h2>";
                        // print_r($_SESSION);
                    ?>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 col-lg-offset-4 colonna-centrale"
                                role="main">
                                <h1 class="content-block-title clearfix" id="main-content">
                                    Iscriviti ad un appello</h1>
                                <br>
                                <form method="POST" action="http://localhost/unimia/scripts/studente/aggiungiIscrizione.php">
                                        <div class="form-group" >
                                            Scegli l'appello a cui iscriverti.
                                            
                                            <!-- ci sarà seleziona un appello del tuo corso di laurea, e seleziona
                                            appelli da altri corsi, controllerò poi nella pagina dello sccript che solo uno
                                            dei due form sia stato usato (inizio con appelli del tuo corso di laurea)  -->

                                            <select id="appello" name="appello" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="" disabled selected hidden >Selezionare appello del tuo cdl</option>
                                                <?php
                                                    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                                                    $dbConnect = openConnection();
                                                    
                                                    $idUtente = $_SESSION["utente"] ; // in session[utente] NON cè la matricola, cè l id utente
                                                    // mi serve la matricola
                                                    $query = "select * from unieuro.get_matricola_studente($1);";
                                                    $res = pg_prepare($dbConnect, "", $query);
                                                    $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente)));

                                                    $matricola = $row[0]['matricola'];
                                                    $_SESSION['matricola'] = $matricola;

                                                    $query = "select appello_id, nome, giorno from unieuro.get_appelli_studente($1);";
                                                    $res = pg_prepare($dbConnect, "", $query);
                                                    $row = pg_fetch_all(pg_execute($dbConnect, "", array($matricola)));
                                                        
                                                    foreach($row as $appello) {  
                                                        if ( $appello['magistrale'] === true) 
                                                            echo '<option value="', $appello['appello_id'],'">',$appello['nome']."   - CDL: "." - magistrale"."   - Data: ".$appello['giorno'],'</option>';
                                                        else echo '<option value="', $appello['appello_id'],'">',$appello['nome']."   - CDL: "." - triennale"."   - Data: ".$appello['giorno'],'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <select id="appelliNonCDL" name="appelliNonCDL" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="" disabled selected hidden >Oppure selezionare appelli da un CDL diverso dal tuo</option>
                                                <?php
                                                    $query = "select appello_id, nome, giorno, cdl from unieuro.get_appelli_cdl_non_studente($1);";

                                                    $res = pg_prepare($dbConnect, "", $query);
                                                    $row = pg_fetch_all(pg_execute($dbConnect, "", array($matricola)));
                                                        
                                                    foreach($row as $appello) {  
                                                        echo '<option value="', $appello['appello_id'],'">',$appello['nome']."   - CDL: ".$appello['cdl']."   - Data: ".$appello['giorno'],'</option>';
                                                    }
                                                ?>
                                            </select>
                                            
                                            <br>

                                            <br>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Iscriviti all esame</button>
                                        </div>
                                    </form>
                            </div>
                        </div>    
                </div>
            </div>
        </div>







    </body>


</html>
