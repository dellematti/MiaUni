<?php

session_start();


$pdo = require 'connessioneDatabase.php';
if ($pdo) {
    echo "Connected to the database successfully!";
} 

if (isset($_POST["email"], $_POST["password"])) {   // controllo se ci sono email e password

}



?>