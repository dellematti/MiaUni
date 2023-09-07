<?php

function openConnection() {
        $dbConnect = pg_connect("host=localhost port=5432 dbname=unimia user=postgres password=pangolino");
        return  $dbConnect;
}
    
    function endConnection($dbConnect){
        pg_close($dbConnect);
    }
 
    function redirect($path){
        header("location:".$path);
    }



?>