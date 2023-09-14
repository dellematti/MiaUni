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
                <h1>Corsi di laurea dell ateneo</h1>
                <p>Tutti i corsi di laurea erogati dall ateneo
                
                <div class="row top-buffer right-buffer" id="">



                <table>
                    <tr>
                        <th>Corso di laurea</th>
                    </tr>
                    <?php
                        session_start();
                        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                        $dbConnect = openConnection();

                        // $query = "select * from unieuro.get_esami_studente($1)";
                        $query = " SELECT * FROM unieuro.get_corsi_di_laurea()"; 
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array( )));

                        $idUtente = $_SESSION["corsiCDL"] = $cdl['id'] ;  // corsiCDL è l id del cdl di cui voglio vedere i corsi
                        foreach($row as $cdl)  {
                            // <td>',$cdl['nome'],'</td>
                            echo '<tr>
                            <td><a href="insegnamenti_cdl.php">', $cdl['nome'],'</a></td>
                            <td>',$cdl['magistrale'],'</td>
                            <td>',$cdl['descrizione'],'</td>
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