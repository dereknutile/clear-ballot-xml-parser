<?php

    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    /**
     * Instantiate the class
     */
    $e = new Washco\Election;

    $output = '<p class="alert alert-info">Status: <strong>No input file found</strong>.</p>';
    $success = false;

    if($_POST['file']){

        $file = html_entity_decode(trim($_POST['file']));

        /**
         * Set class variables
         */
        $e->inputDirectory = $data_directory;
        $e->inputFile = $file;
        $e->outputDirectory = $output_directory;
        $e->outputFile = $output_file;
        $e->partialsDirectory = $partials_directory;
        $e->publicDirectory = $public_directory;
        $e->processedDirectory = $processed_directory;
        $e->timeStamp = date('Y-m-d-H-i-s'); // year-mm-dd-hh-mm-ss
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
        $e->processInputFile();
        $e->addPartial('foot.html');

        /**
         * Write the completed html string, create a preview file, and archive
         * the xml.
         */
        $e->writeOutputFile();
        $e->archiveXmlFile();

        $output  = '<p class="alert alert-info">Status: <strong>'.$file.'</strong> processed successfully!</p>';
        $output .= '<h3>Summary</h3>';
        $output .= '<p>The <strong>'.$file.'</strong> file has been processed and the original has been copied to the archive directory and renamed: <strong>'.$e->timeStamp.'-'.$file.'</strong>.</p>';
        $output .= '<hr />';
        $output .= '<div class="input-file-actions">';
        $output .= '<a class="btn btn-default" href="preview.html" target="_blank"><i class="fa fa-eye"></i>&nbsp;Preview HTML</a>&nbsp;';
        $output .= '<a class="btn btn-primary" href="download.php"><i class="fa fa-download"></i>&nbsp;Download HTML File</a></p>';
        $output .= '</div><!-- /.input-file-actions -->';
        $success = true;
    }

    include($partials_directory.'/head.html');
    include($partials_directory.'/nav.html');
?>

    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <img src="https://s3.amazonaws.com/washcomultimedia/web/img/logo.png" class="img-responsive img-center img-padded" />
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="page-header">
                    <h1>ClearBallot XML Processing Page</h1>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->


        <div class="row add-top-padding">
            <div class="col-md-3">
                <nav class="hidden-print sidebar">
                    <?php if($success): ?>
                    <h4 class="sidebar-heading">Processing Overview</h4>
                    <p class="instructions">Once a file is processed, the XML file will be moved into the <strong>processed/xml</strong> directory with an appropriate timestamp, and the resulting HTML file will be available to you in the <strong>processed/html</strong> directory.</p>
                    <h4 class="sidebar-heading">Instructions</h4>
                    <ol>
                        <li>If appropriate, select the Next Poll Time for the file you wish to process.</li>
                        <li>Click Process</li>
                    </ol>
                    <?php else: ?>
                    <h4 class="sidebar-heading">Instructions</h4>
                    <ol>
                        <li>Drop one or more ClearBallot formatted XML files into the <strong>input</strong> directory and refresh this page.</li>
                        <li>Your file(s) will appear in the main area with an option to add a Next Poll Time and a Process action.</li>
                    </ol>
                    <?php endif; ?>
                </nav>
                <p>
                    <a href="landing.php" class="btn btn-default btn-block"><i class="fa fa-globe"></i>&nbsp;Generate Landing Page</a>
                </p>
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="content">
                <?php echo $output; ?>
                </div><!-- /.content -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- /.container -->

<?php
    include($partials_directory.'/foot.html');
?>