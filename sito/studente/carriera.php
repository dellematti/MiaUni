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
                        // session_start();     // NON serve perchè l ho gia fatto prima in questa pagina
                        $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
                        
                        // prendo la matricola dall email
                        $query = 'SELECT s.matricola
                        FROM unieuro.utenti AS u
                        INNER JOIN unieuro.studenti AS s ON s.utente = u.id
                        WHERE u.email = \'mattia.delledonne@studenti.unimi.it\' ';
                        $data = $pdo->query($query);
                        // echo$data[0]['matricola'],"ciao";    // non si può fare perchè $data è un oggetto e non un array
                        
                        foreach($data as $row)  $matricola = $row['matricola']; // non serve avere il ciclo, le row sono 1 sola
                        // echo$matricola;
                        // echo "tipo della vavriabile ",  gettype($matricola);  // matricola è integer

                        $query = 'SELECT se.studentematricola , a.giorno , i.nome , i.cfu, se.voto -- per ora seleziono solo questo, potrei selezionare altro come l anno, cdl,... 
                        FROM unieuro.studentiesami  AS se
                        INNER JOIN unieuro.appelli AS a ON a.appello_id = se.appello_id  -- Joino il risultato con l appello 
                        INNER JOIN unieuro.insegnamenti AS i ON a.insegnamento_id = i.id -- e joino tutto con gli insegnamenti
                        WHERE se.studentematricola = $matricola';      // 987180 è il parametro da cambiare in base allo studente
                        $data = $pdo->query($query);    // qua ho messo pdo ma nell esempio c era connect
                    
                        foreach($data as $row) { 
                            // print_r($row);
                            echo '<tr>
                            <td>',$row['nome'],'</td>
                            <td>',$row['voto'],'</td>
                            <td>',$row['giorno'],'</td>
                            <td>',$row['cfu'],'</td>
                            </tr>';
                        }
                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>


</body>