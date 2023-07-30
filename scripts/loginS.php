<?php

// questa è una pagina di "passaggio" che va dalla pagina di login, alla homepage del pipo giusto in base all utente


session_start();
// require_once('connessioneDatabase.php');   // collego al database


$pdo = require 'connessioneDatabase.php';
if ($pdo) {
    echo "Connected to the database successfully!";
} 
// start working with the database

if (isset($_SESSION['session_id'])) {     // sel utente è già loggato
    // header('Location: dashboard.php');
    exit;
}


if (isset($_POST["email"], $_POST["password"])) {   // controllo se ci sono email e password
    // pg_close($connection);      alla fine dovrò chiudere la connessione ?????
    echo "<br>email da cercare: ", $_POST['email'];
    echo "<br>password da cercare: ", $_POST['password'];

    // if ($_POST["email"] === null) {   // ha senso questo dopo aver già messo isset ??
    //     $_SESSION['autenticazione_fallita'] = "Credenziali non corrette, riprova";
    //     // header('Location: ../pagine/index.php');
    // }

    $query = 'SELECT * FROM uniEuro.utenti';
    $data = $pdo->query($query);    // qua ho messo pdo ma nell esempio c era connect

    $login = false;
    foreach($data as $row) {        // ora qua posso cercare nei vari record se è presente email e password
        echo "<br><br>email trovato: ", $row['email'];
        echo "<br>pswrd trovato: ", $row['pswrd'];

        if ( $row['email'] == $_POST['email']  && $row['pswrd'] == $_POST['password'] ) {
            $login = true;
            break;
        }
    }

    echo "<br>login", $login ? 'true' : 'false';     // sta cosa perchè in php non si può stampare un boolean        bello
    if ( $login == true) {
        $_SESSION['isLogin'] = true;
        $_SESSION['email'] = $row["email"];
        
        $dominio = explode("@", $row["email"])[1];    // 1 serve perchè con 1 prende la parte dopo "@", con 0 invece la parte prima
        echo "<br>dominio trovato: ", $dominio;
        print_r($_SESSION);

        // ora in base al tipo di dominio, modifico la sessione, e mando alla pagina dell homepage del tipo giusto
        if ($dominio == "studenti.unimi.it") {
            $_SESSION['studente'] = true;
            header('Location: ../sito/studente/homepage.php');
        }else if ($dominio == "docenti.unimi.it") {
            $_SESSION['docente'] = true;
            header('Location: ../sito/docente/homepage_docenti.php');
        }else if ($dominio == "segreteria.unimi.it") {
            $_SESSION['segreteria'] = true;
            header('Location: ../sito/segreteria/homepage_segreteria.php');
        }
    }else{
        // qua è il caso in cui il login non sia andato a buon fine
        // facciamo il redirect alla pagina di login di nuovo
        // header('Location: ../sito/login.php');
    }


  

}






    
//  else {
//         $_SESSION['isLogin'] = true;
// 
//         $_SESSION['email'] = $row["email"];
//         
//         $dominio = explode("@", $row["email"])[1];
// 
//         switch ($dominio) {
//             case "studenti.unitua.it":
//                 $_SESSION['isStudente'] = true;
//                 $_SESSION['isDocente'] = false;
//                 $_SESSION['isSegreteria'] = false;
//                 header('Location: ../pagine/studente/home_stud.php');
//                 break;
//             case "docenti.unitua.it":
//                 $_SESSION['isStudente'] = false;
//                 $_SESSION['isDocente'] = true;
//                 $_SESSION['isSegreteria'] = false;
//                 header('Location: ../pagine/docente/home_doc.php');
//                 break;
//             case "segreteria.unitua.it":
//                 $_SESSION['isStudente'] = false;
//                 $_SESSION['isDocente'] = false;
//                 $_SESSION['isSegreteria'] = true;
//                 header('Location: ../pagine/segreteria/home_seg.php');
//                 break;
//             default:
//                 $_SESSION['autenticazione_fallita'] = "Dominio non riconosciuto, riprova";
//                 header('Location: ../pagine/index.php');
//                 break;
//         }
//     }

























/*

if (isset($_POST['email'], $_POST['password'] )) {   // controllo che ci siano email e password
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {   // non avevo già controllato prima ??
        $msg = 'Inserisci email e password %s';
    } else {
        echo "<br>sono nell else, faccio la query";


        // preparo la query
        $query = "                                    
            SELECT email, password
            FROM uniEuro.utenti
            WHERE email = :email
        ";
        echo $query;
        // evito che venga fatta la piu facile sql injection di sempre
        $check = $pdo->prepare($query);
        $check->bindParam(':email', $email, PDO::PARAM_STR);
        $check->execute();   // eseguo la query


        // print_r($check);
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'Credenziali utente errate %s';
        } else {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['email'];
            
            header('Location: login.php');     // qua metterò l homepage in base al tipo di utente ( farò 3 homepage diverse)
            exit;
        }
    }
    
    printf($msg, '<a href="../login.html">torna indietro</a>');
}

*/