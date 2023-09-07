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
                        echo "<h2 class=\"top-buffer-s\">",$_SESSION['email'],"</h2>";
                        // print_r($_SESSION);
                    ?>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 col-lg-offset-4 colonna-centrale"
                                role="main">
                                <h1 class="content-block-title clearfix" id="main-content">
                                    Aggiungi esito esame</h1>
                                <br>
                                <form method="POST" action="http://localhost/unimia/scripts/docente/aggiungiEsito.php">
                                        <div class="form-group" >
                                            Inserisci le informazioni necessarie registrare l' esito di un esame.
                                            
                                            <!-- saranno: SELEZIONA APPELLO e ci sarà il nome dell insegnamento
                                                          SELEZIONA STUDENTE con il suo nome e matricola, e SELEZIONA VOTO -->


                                            <select id="appello" name="appello" class="form-control input-lg typeahead top-buffer-s">
                                                <option value="" disabled selected hidden >Selezionare appello</option>
                                                <?php
                                                    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                                                    $dbConnect = openConnection();
                                                    
                                                    $idUtente = $_SESSION["utente"] ; // in session[utente] cè l id del docente
                                                    $query = "select appello_id, giorno, nome, magistrale, nome_cdl from unieuro.get_appelli_docente($1)";
                                                    $res = pg_prepare($dbConnect, "", $query);
                                                    $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente)));
                                                    // if (is_null($row["appello_id"])) {
                                                        //     $_SESSION["error"] = "errore.";
                                                        //     redirect("../login.php");   // cambiare path
                                                        // }
                                                        
                                                        
                                                    foreach($row as $appello) {  
                                                        // print_r ($appello);
                                                        // if ( $appello['magistrale'] != 'f') 
                                                        if ( $appello['magistrale'] === true) 
                                                            echo '<option value="',$appello['appello_id'],'">',$appello['nome']."   - CDL: ".$appello['nome_cdl']." - magistrale"."   - Data: ".$appello['giorno'],'</option>';
                                                        else echo '<option value="',$appello['appello_id'],'">',$appello['nome']."   - CDL: ".$appello['nome_cdl']." - triennale"."   - Data: ".$appello['giorno'],'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <br>


                                            <p>Inserire studente :</p>
                                            <input list="matricole" name="matricola" class="form-control input-lg typeahead top-buffer-s">
                                            <datalist id="matricole" >
                                                <?php
                                                    $dbConnect = openConnection();
                                                    $query = "select matricola, nome, cognome from unieuro.get_studenti()";
                                                    $res = pg_prepare($dbConnect, "", $query);
                                                    $row = pg_fetch_all(pg_execute($dbConnect, "",array() )); // non riceve nessun parametro in ingresso



                                                    foreach($row as $studente) {  
                                                        echo '<option value="',$studente['matricola'],'">',$studente['nome']." ".$studente['cognome'],'</option>';
                                                    }
                                                ?>    
                                            </datalist>

                                            <p class ="top-buffer-s">Inserire esito esame :</p>
                                            <input id="esito"  class=" input-lg typeahead top-buffer-s form-control  rounded-0 my-4" name="esito" type="number"  placeholder="valutazione" 
                                            aria-label="esito" value="" max="31" min="0" aria-describedby="basic-addon1">


                                            <br>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Aggiungi esito</button>
                                        </div>
                                    </form>
                            </div>
                        </div>    
                </div>
            </div>
        </div>
</body>

</html>