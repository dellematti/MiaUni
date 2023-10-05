<!DOCTYPE html>
<html>

<head>
    <title>Cambio password</title>
    <link href="http://localhost/unimia/css/cssLogin.css" rel="stylesheet">
    <meta charset="utf-8">
</head>


<body >
    <header class="header" role="banner">
        <div class="logo-container container-fluid">
            <div>
                <a class="nav-link active" id="uni" aria-current="page" href="/">Mia<span id="euro">Uni</span></a>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3 col-lg-offset-4 colonna-centrale"
            role="main">
            <h1 class="content-block-title clearfix" id="main-content">
                Cambio password</h1>
            <br>
                <form method="POST" action="../scripts/cambioPassword.php">
                    <div class="form-group " >
                        <p>Inserire la vecchia e la nuova password: </p>
                        <input id="passwordPrecedente" class="form-control input-lg pass top-buffer-s" name="passwordPrecedente" type="password" class="form-control  bg-transparent rounded-0 my-4" 
                            placeholder="Password precedente" aria-label="Username" aria-describedby="basic-addon1" value="password">
                        <br>
                        <input id="password" class="form-control input-lg pass" name="password" type="password" class="form-control  bg-transparent rounded-0 my-4" 
                            placeholder="Password nuova" aria-label="Username" aria-describedby="basic-addon1" value="password1">
                        <br>
                        <input id="passwordConferma" class="form-control input-lg pass" name="passwordConferma" type="password" class="form-control  bg-transparent rounded-0 my-4" 
                            placeholder="Conferma la password" aria-label="Username" aria-describedby="basic-addon1" value="password1">
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Cambia password</button>
                    </div>
                </form>
        </div>
    </div>

    
    <footer id="footer" class="container footer text-center top-buffer-s" >
        <nav>
            <ul>
                <li>
                    <a href="#">Dichiarazione di accessibilità</a>
                </li>
                <li>
                    <a href="#">Privacy e cookie</a>
                </li>
            </ul>
        </nav>
        <p class="firma">Università degli studi di Informatica</p>
        <p>
            <a href="#">Assistenza MiaUni</a>
        </p>
    </footer>
</body>

</html>