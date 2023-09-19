<?php
session_start();

if (isset($_POST["passwordPrecedente"], $_POST["password"],  $_POST["passwordConferma"]) && $_POST["password"] == $_POST["passwordConferma"]  ) :  
    $passwordPrecedente = $_POST['passwordPrecedente'];
    $password = $_POST['password'];
    $idUtente = $_SESSION['utente'];

    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();

    $query = "CALL modifica_password ( $1, $2, $3 );";
    $res = pg_prepare($dbConnect, "", $query);
    $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente, $passwordPrecedente, $password)));
    ?>

<html>
    <head>
        <style>
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            /* position:fixed ; */
            margin-left: 680px;
            margin-top: 20px;
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }
        </style>
    </head>

    <body >
        <h2 style="text-align:center;  margin-top: 3em;"> Cambio password in corso</h2>
        <div class="loader"></div>
        <script>
            (async () => {
                await new Promise(resolve => setTimeout(resolve, 3000));
                window.location.replace("http://localhost/unimia/sito/login2.php");
            })();
        </script>
    </body>
</html>

<!-- perchè lo devo aprire? in teoria se non entro nell if non si è mai chiuso il php -->
<?php
else:
?>




<html>
    <head>
        <style>
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            /* position:fixed ; */
            margin-left: 680px;
            margin-top: 20px;
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }
        </style>
    </head>

    <body >
        <!-- <p style="text-align:center;  margin-top: 12em;">Errore nel cambio password </p> -->
        <h2 style="text-align:center;  margin-top: 3em;">Errore nel cambio password </h2>
        <div class="loader"></div>
        <script>
            (async () => {
                await new Promise(resolve => setTimeout(resolve, 3000));
                window.location.replace("http://localhost/unimia/sito/cambioPassword.php");
            })();
        </script>
    </body>
</html>

<?php
endif;
?> 


<!-- il body potrei scriverlo una volta sola ad esempio in una funzione che riceve come parametro se il login ha funzionato, e
     in base a quello decide dove redirigere l utente-->