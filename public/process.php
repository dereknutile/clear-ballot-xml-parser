<?php

    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    /**
     * Instantiate the class
     */
    $e = new Washco\Election;

    $output = "No input file";

    if($_POST['file']){

        $file = html_entity_decode(trim($_POST['file']));

        /**
         * Set class variables
         */
        $e->inputDirectory = $data_directory;
        $e->importFile = $file;
        $e->outputDirectory = $output_directory;
        $e->outputFile = $output_file;
        $e->partialsDirectory = $partials_directory;
        $e->appTitle = $app_title;
        $e->logoUrl = $logo_url;

        /**
         * Set POST variables
         */
        if($_POST['status']){
            $e->postStatus = $_POST['status'];
        }
        if($_POST['date']){
            $e->postDate = $_POST['date'];
        }
        if($_POST['time']){
            $e->postTime = $_POST['time'];
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
        $output = $file." processed";
    }

    include($partials_directory.'/head.html');
    include($partials_directory.'/nav.html');

    echo '<div class="container add-top-padding">';
    echo '<h2>'.$output.'</h2>';
    echo '</div>';

    include($partials_directory.'/foot.html');
?>