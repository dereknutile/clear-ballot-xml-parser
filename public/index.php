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
    $e->inputDirectory = $data_directory;

    /**
     * Build the xml forms, or not there are none, and assign to a variable
     */
    $xml = $e->findXmlFiles();
    $xml_form_content = $e->buildXmlFormContent($xml);

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
                    <h1>ClearBallot XML Parsing Tool</h1>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row add-top-padding">
            <div class="col-md-3">
                <nav class="hidden-print sidebar">
                    <?php if($xml): ?>
                    <h4 class="sidebar-heading">Parsing Overview</h4>
                    <p class="instructions">The parsing process takes the ClearBallot XML file and turns it into a simple HTML file that can be reviewed and then posted to the production website.</p>
                    <h4 class="sidebar-heading">Instructions</h4>
                    <ol>
                        <li>Choose a <strong>Status Banner</strong>.</li>
                        <li>Optionally enter a day when the next update will occur.</li>
                        <li>Select the next time an update will occur.</li>
                        <li>Click <strong>Process</strong> to generate the HTML and preview the output.</li>
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
                <?php echo $xml_form_content; ?>
                </div><!-- /.content -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include($partials_directory.'/foot.html'); ?>
