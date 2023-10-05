
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
                        <a class="nav-link active" id="uni" aria-current="page" href="/">Mia<span id ="euro">Uni</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <div class="main-content">
        <div class="container pt-4 mt-5">
            <div class="row justify-content-between">
                <h1>Insegnamenti del corso di laurea</h1>
                <div class="row top-buffer right-buffer" id="">

                <table>
                    <tr>
                        <th>Corso di laurea</th>
                        <th>Cfu</th>
                        <th>Docente</th>
                        <th>Email docente</th>
                    </tr>
                    <?php
                        session_start();
                        require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
                        if(isset($_GET['cdl']) ){    // prendo dal url l id del cdl
                            $cdl = $_GET['cdl'];
                        }
                        $dbConnect = openConnection();
                        
                        $query = "select * from  unieuro.get_informazioni_cdl($1)"; 
                        $res = pg_prepare($dbConnect, "", $query);
                        $row = pg_fetch_all(pg_execute($dbConnect, "", array($cdl )));

                                            
                        foreach($row as $cdl)  {
                            // <td>',$cdl['nome'],'</td>
                            echo '<tr>
                            <td><a href="insegnamento.php?insegnamento=',$cdl['id']   ,'">', $cdl['nome'],'</a></td>
                            <td>',$cdl['cfu'],'</td>
                            <td>',$cdl['docente_nome']." ".$cdl['docente_cognome'],'</td>
                            <td>',$cdl['email'],'</td>
                            </tr><br>';
                        }   
                        // si potrebbe aggiungere la pagina di informazioni del docente, clicco sul nome e si apre la pagina

                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>


</body>