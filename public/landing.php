<?php
    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    // /**
    //  * Instantiate the class
    //  */
    // $e = new Washco\Election;

    // /**
    //  * Set class variables
    //  */
    // $e->inputDirectory = $data_directory;

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
                    <h1>Landing Page Builder</h1>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row add-top-padding">
            <div class="col-md-3">
                <nav class="hidden-print sidebar">
                    <h4 class="sidebar-heading">Landing Page</h4>
                    <p class="instructions">The landing page is what visitors see on the election results website when Washington County is holding no elections.</p>
                </nav>
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="content">

                </div><!-- /.content -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include($partials_directory.'/foot.html'); ?>
