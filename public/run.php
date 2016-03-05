<?php

    $next = '';

    if($_GET['next']){
        $next = htmlspecialchars( $_GET['next'] );
    }

    include(__DIR__.'/index.php');
    echo "Complete.";