<?php

    $alert = false;

    /**
     * Bootstrap the application
     */
    require(__DIR__.'/../app/bootstrap.php');

    if (!empty($_POST))
    {
        /**
         * Instantiate the class
         */
        $e = new Washco\Election;

        /**
         * Set class variables
         */
        $e->outputDirectory = $output_directory;
        $e->outputFile = 'landing.htm';
        $e->partialsDirectory = $partials_directory;
        $e->publicDirectory = $public_directory;
        $e->processedDirectory = $processed_directory;
        $e->timeStamp = date('Y-m-d-H-i-s'); // year-mm-dd-hh-mm-ss
        $e->appTitle = $app_title;
        $e->logoUrl = $logo_url;

        if($_POST['date']){
            $e->postDate = htmlentities($_POST['date']);
            $alert = true;
        }

        if($_POST['content']){
            $e->postContent = htmlentities($_POST['content']);
            $alert = true;
        }

        /**
         * Build the html string
         */
        $e->addPartial('head.html');
        $e->addPartial('nav.html');
        $e->processLandingForm();
        $e->addPartial('foot.html');
        $e->writeLandingPageFile();
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
                    <h1>Landing Page Builder</h1>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row add-top-padding">
            <ol class="breadcrumb">
                <li><a href="<?php echo $base_url; ?>">Home</a></li>
                <li>Landing Page</li>
            </ol>
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-3">
                <nav class="hidden-print sidebar">
                    <h4 class="sidebar-heading">Landing Page</h4>
                    <p class="instructions">The landing page is what visitors see on the election results website when Washington County is holding no elections.</p>
                </nav>
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="content">
                <?php if($alert): ?>
                    <p class="alert alert-info">Landing page successfully generated. <a class="btn btn-primary" href="download.php?file=landing.htm"><i class="fa fa-download"></i>&nbsp;Download Landing Page HTML</a></p>
                <?php endif; ?>
                <div class="input-file">
                    <form action="landing.php" method="post" id="builder">
                        <div class="form-group">
                            <label for="time" class="control-label">Next Election Date (optional)</label>
                            <input type="text" class="form-control" name="date" placeholder="Thursday, November, 7" value="<?php echo $_POST['date']; ?>">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="content" class="control-label">Landing Page Content</label>
                            <textarea class="form-control" rows="3" name="content" id="wysiwyg">
                                <?php if($_POST['content']): ?>
                                    <?php echo $_POST['content']; ?>
                                <?php else: ?>
                                    <h3><?php echo date('Y'); ?> Election Dates Example</h3>
                                    <p><?php echo date('F d, Y'); ?></p>
                                    <p><?php echo date('F d, Y'); ?></p>
                                    <h3><?php echo date('Y', strtotime('+1 year')); ?> Election Dates Example</h3>
                                    <p><?php echo date('F d, Y', strtotime('+1 year')); ?></p>
                                <?php endif; ?>
                            </textarea>
                        </div><!-- /.form-group -->

                    <div class="input-file-actions">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-cogs"></i>&nbsp;Generate</button>
                    </div><!-- /.input-file-actions -->
                    </form>
                </div><!-- /.input-file -->

                </div><!-- /.content -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include($partials_directory.'/foot.html'); ?>
