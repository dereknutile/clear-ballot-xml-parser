<?php

    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    /**
     * Instantiate the class
     */
    $e = new Washco\Election;

    /**
     * Set class variables
     */
    $e->importFile = $data_directory.$import_file;
    $e->outputFile = $output_directory.$output_file;
    $e->partialsDirectory = $partials_directory;
    $e->appTitle = $app_title;
    $e->logoUrl = $logo_url;
    if(isset($next)){
        $e->nextTime = $next;
    }

    /**
     * Build the html string
     */
    $e->addPartial('head.html');
    $e->addPartial('nav.html');
    $e->processImportFile();
    $e->addPartial('foot.html');

    /**
     * Write the completed html string
     */
    $e->writeOutputFile(false);

    include($partials_directory.'/head.html');
    include($partials_directory.'/nav.html');

    echo '<div class="container add-top-padding">';
    var_dump($_POST);
    if($_POST['file']){
        echo "<p>File: ".htmlspecialchars($_POST['file'])."</p>";
    } else {
        echo "<p>No file posted.</p>";
    }

    echo '</div>';

    include($partials_directory.'/foot.html');
?>