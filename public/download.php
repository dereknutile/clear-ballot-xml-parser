<?php
    $file = "preview.html";

    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=index.htm");

    readfile ($file);
?>