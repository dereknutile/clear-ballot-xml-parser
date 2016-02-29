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
    $e->dd("Parse Complete.")
?>