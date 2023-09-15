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
                    echo "<h2 class=\"top-buffer-s\">",$_SESSION['email'],"</h2>"
                ?>
                <div class="row top-buffer right-buffer" id="">

                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Matricola</th>
                        <th>Corso di laurea</th>
                    </tr>
                    <?php
                        $pdo = require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase.php';
                        

                        $query = "SELECT u.nome , u.cognome , u.email , s.matricola , c.nome ,c.magistrale 
                        FROM unieuro.utenti AS u
                        INNER JOIN unieuro.studenti AS s ON s.utente = u.id
                        INNER JOIN unieuro.corsidilaurea AS c ON s.cdl = c.id 
                        WHERE u.email = '{$_SESSION['email']}' ";

                        $data = $pdo->query($query);

                        // ho row[0] perchò nel db ho sia 'nome' per cdl che per utente, dovrei cambiarne uno                      
                        foreach($data as $row) {   
                            echo '<tr>
                            <td>',$row[0],'</td>  
                            <td>',$row['cognome'],'</td>
                            <td>',$row['matricola'],'</td>
                            <td>',$row['nome'],'</td>
                            </tr>';
                        }

                    ?>
                </table>
                </div>
                <div class="d-grid gap-2 d-md-block">
                    <a href="http://localhost/unimia/sito/cambioPassword.php" class="btn btn-primary btn-lg  top-buffer"  >Clicca qui per cambiare la tua password </a>
                </div>

            </div>
        </div>
    </div>


</body>