<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Unimia</title>

    <!-- Main Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- <link href="../css/style.css" rel="stylesheet">
    <link href="../css/cssMio.css" rel="stylesheet"> -->

</head>



<body>
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


    <main id = login>                        
        <div class="container pt-4 mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-17  d-flex justify-content-center">
                    <div class="widget p-4 text-center top-buffer" id ="registrazione">
                        <h2 class="widget-title text-white d-inline-block mt-4">Login</h2>
                        <div class="top-buffer-s">
                            <p class="mt-4">Effettua il login per accedere al tuo account personale</p>
                        </div>
                        <form method="POST" action="../scripts/loginS.php">
                            <div class="form-group">
                                <input id="email" name="email" type="email" class="form-control bg-transparent rounded-0 my-4" placeholder="Email" 
                                    aria-label="Email" value="mattia.delledonne@studenti.unimi.it" aria-describedby="basic-addon1">
                                <input id="password" name="password" type="password" class="form-control  bg-transparent rounded-0 my-4" 
                                    placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" value="password">
                                    <button type="submit" class="btn btn-primary">login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>