<?php

    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    /**
     * Instantiate the class
     */
    $e = new Washco\Election;

    // array(4) { ["status"]=> string(4) "none" ["date"]=> string(0) "" ["time"]=> string(4) "none" ["file"]=> string(23) "import-washco-empty.xml" }

    $output = "No input file";

    if($_POST['file']){

        $file = html_entity_decode(trim($_POST['file']));
        /**
         * Set class variables
         */
        $e->importFile = $data_directory.$file;
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
        $output = $file." processed";
    }

    include($partials_directory.'/head.html');
    include($partials_directory.'/nav.html');

    echo '<div class="container add-top-padding">';
    echo '<h2>'.$output.'</h2>';
    echo '</div>';

    include($partials_directory.'/foot.html');
?>