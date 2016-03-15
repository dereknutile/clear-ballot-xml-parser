<?php $xml = false; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Washington County Oregon Election Results">
        <meta name="author" content="Washington County Oregon Election Results">

        <title>Washington County Oregon Election Results</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://s3.amazonaws.com/washcomultimedia/web/css/custom.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <!-- Start custom css -->
    <style>
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        /* application specific */
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
        .unofficial {
            padding: 12px 0 12px;
            background-color: #eee;
            margin-bottom: 12px; }
        .unofficial-copy{
            font-size: 1.25em;
            font-weight: 700;
            margin-bottom: 0;
            text-align: center; }
        .election-summary {
            min-height: 1em;
            padding: 1em;
            margin-bottom: 2em;
            border: 1px solid #4e707e;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); }
        .election-summary p {
            font-size: 1.2em;
            line-height: 1.3em; }
        p.instructions{
            padding: .5em; }
        .sidebar ol>li {
            display: list-item;
            padding: .5em;
            margin-left: .5em; }
        .input-file {
            border: 1px solid #4e707e;
            padding: 1em;
            margin-bottom: 2em;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); }
        .input-file-actions {
            margin-top: 1em;
            border-top: 1px solid #eee;
            padding-top: 1em;
            text-align: right; }
        h5.input-file-title {
            margin: 0;
            font-size: 1.4em;
            color: #4e707e;
            text-shadow: none;
            padding: .5em; }
        .add-top-padding {
            padding-top: 2em; }
    </style>
    <!-- End custom css -->
<body class="fixed-navbar">

    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand text-shadow-dark" href="/">Washington County Elections</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://www.co.washington.or.us/" target="_blank">County Website</a></li>
                    <li><a href="http://www.co.washington.or.us/assessmenttaxation/elections" target="_blank">Elections</a></li>
                    <li><a href="http://www.co.washington.or.us/AssessmentTaxation/Elections/ElectionsArchive" target="_blank">Archives</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!-- /.navbar -->

    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <img src="https://s3.amazonaws.com/washcomultimedia/web/img/logo.png" class="img-responsive img-center img-padded" />
                <nav class="hidden-print sidebar">
                    <h4 class="sidebar-heading">Instructions</h4>
                    <ol>
                        <li>Drop one or more XML files into the <strong>input</strong> directory and refresh this page.</li>
                        <li>Your file(s) will appear in the main area with an option to add a Next Poll Time and a Process action.</li>
                    </ol>
                </nav>
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="page-header">
                    <h1>ClearBallot XML Parsing Tool</h1>
                </div>

                <div class="content add-top-padding">
                <?php if($xml): ?>
                <div class="input-file">
                    <div class="media">
                    <h5 class="input-file-title">filename.xml</h5>
                      <div class="media-left">
                        <span class="media-object">
                            <i class="fa fa-5x fa-file-text"></i>
                        </span><!-- /.media-object -->
                      </div>
                      <div class="media-body">
                          <div class="form-group">
                            <label for="time" class="control-label">Next Poll Time</label>
                            <select id="time" class="form-control">
                            <option value="0">None</option>
                            <?php for($i = 0; $i < 24; $i++): ?>
                          <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                            <?php endfor ?>
                            </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.media-body -->
                    </div><!-- /.media -->
                    <div class="input-file-actions">
                        <a href="#" class="btn btn-default"><i class="fa fa-eye"></i>&nbsp;Preview</a>
                        <a href="#" class="btn btn-primary"><i class="fa fa-cogs"></i>&nbsp;Process</a>
                    </div><!-- /.media-actions -->
                </div><!-- /.input-file -->

                <div class="input-file">
                    <div class="media">
                    <h5 class="input-file-title">filename.xml</h5>
                      <div class="media-left">
                        <span class="media-object">
                            <i class="fa fa-5x fa-file-text"></i>
                        </span><!-- /.media-object -->
                      </div>
                      <div class="media-body">
                          <div class="form-group">
                            <label for="time" class="control-label">Next Poll Time</label>
                            <select id="time" class="form-control">
                            <option value="0">None</option>
                            <?php for($i = 0; $i < 24; $i++): ?>
                          <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                            <?php endfor ?>
                            </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.media-body -->
                    </div><!-- /.media -->
                    <div class="input-file-actions">
                        <a href="#" class="btn btn-default"><i class="fa fa-eye"></i>&nbsp;Preview</a>
                        <a href="#" class="btn btn-primary"><i class="fa fa-cogs"></i>&nbsp;Process</a>
                    </div><!-- /.media-actions -->
                </div><!-- /.input-file -->
                <?php else: ?>
                <h3>No XML file(s) found!</h3>
                <p>Place one or more XML files in the <strong>/input</strong> directory and refresh this page.</p>
                <?php endif; ?>
                </div><!-- /.content -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <address>
                        <h5>Washington County Elections Office</h5>
                        3700 SW Murray Blvd<br />
                        Suite 101<br />
                        Beaverton, OR 97005
                    </address>
                </div>
                <div class="col-md-6">
                    <address>
                        <h5>Contact Us</h5>
                        <abbr title="Phone"><i class="fa fa-phone"></i></abbr> (503) 846-5800<br />
                        <abbr title="Fax"><i class="fa fa-fax"></i></abbr> (503) 846-5810<br />
                        <abbr title="Email"><i class="fa fa-envelope"></i></abbr> <a href="http://www.co.washington.or.us/divisionemailform.cfm?id=5" target="_blank">Email</a>
                    </address>
                </div>
            </div><!-- /.row -->
            <div class="row">
                <p class="copyright">Washington County Oregon</p>
            </div><!-- /.row -->
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>
