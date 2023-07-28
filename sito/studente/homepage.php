<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <title>UniEuro</title>

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- ora che l homepage è dentro la cartella, per recuperare il css metto tutto il path -->
    <link href="http://localhost/css/cssMio.css" rel="stylesheet">
    <link href="http://localhost/css/cssMio.css" rel="stylesheet">

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
                                    <!-- <div class="card cardSelezionabile bg-dark p-3 h-100"> -->
                                    <div class="card cardSelezionabile bg p-3 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Iscrizione esami</h5>
                                            <img class="card-img    bg" src="https://prog2.di.unimi.it/_images/prog2.png" alt="Card image cap">
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4  bottom-buffer" id="">
                                    <div class="card cardSelezionabile bg p-3 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">La mia carriera</h5>
                                            <img class="card-img    bg" src="https://www.vigilanzatv.it/wp-content/uploads/2021/01/The-Truman-Show-2.jpg" alt="Card image cap">
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4  bottom-buffer" id="">
                                    <div class="card cardSelezionabile bg p-3 h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Informazioni utente</h5>
                                            <img class="card-img    bg" src="https://eyestudios.it/wp-content/uploads/2021/04/9-Consigli-per-Migliorare-lEsperienza-Utente-1024x629.jpg" alt="Card image cap">
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                            <!-- <a class="link text-white px-0 card-text second-link" href="">altro</a> -->
                                        </div>
                                        <!-- <div class="card-footer">
                                            <small class="text-muted">footer</small>
                                        </div> -->
                                    </div>
                                </div>




                            </div>
                </div>
            </div>

        </div>

    <!-- </section> -->
    <!-- END main-wrapper -->


</body>

</html>