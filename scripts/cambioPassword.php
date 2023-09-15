<?php
session_start();
// print_r($_POST);
// print_r($_SESSION);

if (isset($_POST["passwordPrecedente"], $_POST["password"],  $_POST["passwordConferma"]) && $_POST["password"] == $_POST["passwordConferma"]  ) {  
    $passwordPrecedente = $_POST['passwordPrecedente'];
    $password = $_POST['password'];
    $idUtente = $_SESSION['utente'];
    echo "<br>password : ", $passwordPrecedente;
    echo "<br>password : ", $password;
    echo "<br>password : ", $idUtente;

    require 'C:\xampp\htdocs\unimia\scripts\connessioneDatabase2.php';
    $dbConnect = openConnection();

    $query = "CALL modifica_password ( $1, $2, $3  );";
    $res = pg_prepare($dbConnect, "", $query);
    $row = pg_fetch_all(pg_execute($dbConnect, "", array($idUtente, $passwordPrecedente, $password)));

    // dovrei mettere che per qualche secondo cè uno spinner e la scritta cambio password in corso
    

    header('Location: ../sito/login2.php');
}
?>

<body >
    <p> ERRORE nel cambio password </p>
    <script>
        (async () => {
            await new Promise(resolve => setTimeout(resolve, 3000));
            window.location.replace("http://localhost/unimia/sito/cambioPassword.php");
        })();
    </script>
</body>

