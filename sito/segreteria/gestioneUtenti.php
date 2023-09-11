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
                        <div class="row top-buffer right-buffer" id="">
                            <div class="col-4  bottom-buffer" id="">
                                <div class="card cardSelezionabile bg p-3 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Aggiungi utente</h5>
                                        <img class="card-img bg top-buffer-s" src="http://localhost/unimia/img/add.png" alt="Card image cap">
                                        <a id="gestioneUtenti" class="stretched-link" title="Sezione gestione utenti"
                                            href="aggiungiUtente.php" >
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- card gestione CDL -->
                            <div class="col-4  bottom-buffer" id="">
                                <div class="card cardSelezionabile bg p-3 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Rimuovi utente</h5>
                                        <img class="card-img bg" src="http://localhost/unimia/img/remove.jpg" alt="Card image cap">
                                        <a id="gestioneCdl" class="stretched-link" title="Sezione gestione CDL"
                                            href="" >
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- card gestione insegnamenti -->
                            <div class="col-4  bottom-buffer" id="">
                                <div class="card cardSelezionabile bg p-3 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">modifica utente</h5>
                                        <img class="card-img bg" src="http://localhost/unimia/img/modify.png" alt="Card image cap">
                                        <a id="gestioneInsegnamenti" class="stretched-link" title="Sezione gestione insegnamenti"
                                            href="" >
                                            <!-- per modifica utente potrei mettere una pagina che fa vedere le informazioni
                                            attuali dell utente, e un form in cui rimetterle tutte -->
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

        </div>

</body>

</html>