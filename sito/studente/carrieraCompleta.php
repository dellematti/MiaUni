<!-- in questa pagina ci sarà la carriera dello studente, mostrerò tutti gli 
esami svolti, in quale data e qual'è il voto e i cfu ottenuti per esame -->


<head>

    <meta charset="utf-8">
    <title>UniEuro</title>

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- ora che l homepage è dentro la cartella, per recuperare il css metto tutto il path -->
    <link href="http://localhost/unimia/css/cssMio.css" rel="stylesheet">
    <link href="http://localhost/unimia/css/cssMio.css" rel="stylesheet">

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
                <h1>Carriera completa dello studente</h1>
                <p>Tutti gli esami dati, compresi quelli ripetuti e quelli non superati
                <?php
                    session_start();
                    // print_r($_SESSION);
                    echo "<h2 class=\"top-buffer-s\">",$_SESSION['email'],"</h2>"
                ?>
                <div class="row top-buffer right-buffer" id="">
                <!-- qua forse serve un div colonna ??? -->

                <table>
                    <tr>
                        <th>Esame</th>
                        <th>Esito</th>
                        <th>Data</th>
                        <th>CFU</th>
                    </tr>
                    <?php
                        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                        $dbConnect = openConnection();

                        $idUtente = $_SESSION["utente"] ;
                        $query = "select * from unieuro.get_matricola_studente($1);";
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente)));

                        $matricola = $row[0]['matricola'];

                        // $query = "select * from unieuro.get_esami_studente($1)";
                        $query = " SELECT * FROM unieuro.get_carriera_completa_studente($1) "; 
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array($matricola )));

                        
                        foreach($row as $esame)  {
                            echo '<tr>
                            <td>',$esame['corso'],'</td>
                            <td>',$esame['voto'],'</td>
                            <td>',$esame['giorno'],'</td>
                            <td>',$esame['cfu'],'</td>
                            </tr>';
                        }   
                    


                        // DA AGGIUNGERE :
                        // ora dovrei aggiungere tutti gli esami del cdl che mancano allo studente (esami del cdl che hanno
                        // voti null o magari anche minori di 18, devo decidere come gestire le insufficienze)



                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>


</body>