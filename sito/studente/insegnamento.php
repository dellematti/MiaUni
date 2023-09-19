
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
                <h1>Pagina del corso</h1>
                <p>Informazioni sull insegnamento </p>
                <div class="row top-buffer right-buffer" id="">


                <!-- oltre alle informazioni presenti già nella pagina precedente, qua farò vedere anche le propedeuticità del corso -->
                <?php
                        session_start();
                        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                        if(isset($_GET['insegnamento']) ) {    // prendo dal url l id del cdl
                            $insegnamento = $_GET['insegnamento'];
                        }
                        $dbConnect = openConnection();
                        
                        $query = "SELECT * FROM unieuro.get_informazioni_insegnamento($1)"; 
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array($insegnamento )));

                        echo '<h2>'.$row[0]['nome'].'</h2>';
                        echo'<p>CFU: '.$row[0]['cfu']. '</p>' ;
                        echo'<p>Docente: '.$row[0]['nome_docente'].' '.$row[0]['cognome_docente'].'</p>' ;
                    ?>


                <table class="top-buffer">
                    <tr>
                        <th>Propedeuticità</th>
                    </tr>
                    <?php
                        
                        $query = "SELECT * FROM unieuro.get_propedeuticità_insegnamento($1)"; 
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array($insegnamento )));

                                            
                        foreach($row as $propedeuticità)  {
                            // <td>',$cdl['nome'],'</td>
                            echo '<tr>
                            <td><a href="insegnamento.php?insegnamento=',$propedeuticità['id']   ,'">', $propedeuticità['nome'],'</a></td>
                            </tr><br>';
                        }   
                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>


</body>