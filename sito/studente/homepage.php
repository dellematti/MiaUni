<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <title>Unimia</title>

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- ora che l homepage è dentro la cartella, per recuperare il css metto tutto il path -->
    <link href="http://localhost/css/cssMio.css" rel="stylesheet">
    <link href="http://localhost/css/cssMio.css" rel="stylesheet">

</head>



<body >
    <?php
    echo dirname(__FILE__)
    ?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Unimia</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- <section class="d-flex"> -->
        <div class="main-content">
            <div class="container pt-4 mt-5">
                <div class="row justify-content-between">
                        <h2>card studente </h2>
                            <div class="row top-buffer-s right-buffer" id="">
                                <div class="col-4  bottom-buffer" id="">
                                    <div class="card cardSelezionabile bg-dark p-3 h-100">
                                        <img class="card-img    bg-dark" src="" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">titolo</h5>
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                            <!-- <a class="link text-white px-0 card-text second-link" href="">altro</a> -->
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">footer</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4  bottom-buffer" id="">
                                    <div class="card cardSelezionabile bg-dark p-3 h-100">
                                        <img class="card-img    bg-dark" src="" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">titolo</h5>
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                            <!-- <a class="link text-white px-0 card-text second-link" href="">altro</a> -->
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">footer</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4  bottom-buffer" id="">
                                    <div class="card cardSelezionabile bg-dark p-3 h-100">
                                        <img class="card-img    bg-dark" src="" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">titolo</h5>
                                            <a id="albumLink" class="stretched-link" title="Click to do something"
                                                href="" action="risultati" method="GET">
                                            </a>
                                            <!-- <a class="link text-white px-0 card-text second-link" href="">altro</a> -->
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">footer</small>
                                        </div>
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