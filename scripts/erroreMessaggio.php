<?php

    // il primo parametro è il messaaggio di errore, il secondo è il link a cui viene indirizzato l utente 
    function messaggio ($errore, $link) {
        
        echo'<html>
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
                        <h2 style="text-align:center;  margin-top: 3em;">'.$errore.'</h2>
                        <div class="loader"></div>
                        <script>
                            (async () => {
                                await new Promise(resolve => setTimeout(resolve, 3000));
                                window.location.replace("'.$link.'");
                            })();
                        </script>
                    </body>
                    </html>';
    }


?>