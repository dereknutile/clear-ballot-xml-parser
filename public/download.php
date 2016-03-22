<?php
    $file = "preview.htm";
    if($_GET['file']){
        $file = urlencode($_GET['file']);
    }

    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=index.htm");

    readfile ($file);
?>