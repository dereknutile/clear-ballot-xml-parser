
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Washington County Oregon Election Results">

    <title>Washington County Oregon Election Results</title>
    <link href='//fonts.googleapis.com/css?family=Raleway:100,400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto:100,300,400,700' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
      body {
        padding-top: 70px;
        font-weight: 300;
        font-family: 'Roboto';
      }

      h1.election-title {
        font-family: 'Raleway';
        font-size: 2em;
        font-weight: 400;
        color: #001;
        margin-bottom: 1em;
      }

      p {
        font-size: 1.3em;
        line-height: 2em;
        color: #011;
        text-align: left;
      }

      .election-summary {
        border: solid 1px #aaa;
        background-color: #eee;
        padding-left: 1em;
        padding-right: 1em;
      }

      .election-summary>p {
        font-size: 1em;
        line-height: 1.25em;
      }

      h5.contest-title {
        margin: 2em 0 1em;
        font-size: 1.4em;
      }

      footer.footer {
          margin-top: 5em;
          border-top: 1px solid #aaa;
          padding: 2em 0 3em;
          background-color: #eee;
      }

      .copyright {
        margin-top: 2em;
        text-align: center;
        font-weight: 300;
        color: #aaa;
      }
      .well {
        min-height: 1em;
        padding: 1em;
        margin-bottom: 2em;
        background-color: #eee;
        border: 1px solid #aaa;
        border-radius: 0px;
      }
#sidebar {
  border-left: 4px solid #aaa;
}
@media (min-width: 979px) {
  #sidebar.affix {
    position: fixed;
    top:85px;
    width:228px;
  }
}
.affix,.affix-top {
   position:static;
}
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Washington County, OR Election Results</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://www.co.washington.or.us/AssessmentTaxation/Elections/ElectionsArchive/index.cfm" target="_blank">Archives</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        <?php
        $page_title = "Washington County, OR Election Results";
        // Set a variable for the source data directory
        $data_directory = __DIR__.'/../data';

        // Load the target xml file into an XML object using simplexml_load_file
        // if the file is missing it returns false
        $xml = simplexml_load_file($data_directory.'/import.xml' );

        if($xml){
            /**
             * Election
             */
            $election = $xml->Election;
            $page_title = $election['electionTitle'];
            $report_time = $xml->ReportTime;
            $run_date = date('Y-m-d');
            $run_time = date('hh:mm:ss');
            if($report_time){
                $exploded_report_time = explode("T", $report_time);
                $run_date = $exploded_report_time[0];
                $run_time = $exploded_report_time[1];
            }
writeHtml($page_title,"h1","election-title");
echo '<div class="container well">';
echo '<div class="row">';
echo '<div class="col-md-4">';
writeHtml("Run Date: ".$run_date);
writeHtml("Run Time: ".$run_time);
echo '</div><!-- /.col -->';


            $precincts_reported = $election['precinctsReported'];
            $precincts_total = $election['totalPrecincts'];
            $precincts_percentage = $election['precinctsReportedPercentage'];

echo '<div class="col-md-4">';
            writeHtml("Precincts Total: ".$precincts_total);
            writeHtml("Precincts Counted: ".$precincts_reported);
            writeHtml("Precincts Percentage: ".$precincts_percentage);
echo '</div><!-- /.col -->';

            $ballots_cast = $election['totalBallotsCast'];
            $ballots_registered = $election['totalRegistration'];
            $ballots_percentage = $election['totalCastPercentage'];
echo '<div class="col-md-4">';
            writeHtml("Ballots Cast: ".$ballots_cast);
            writeHtml("Ballots Registered: ".$ballots_registered);
            writeHtml("Ballots Percentage: ".$ballots_percentage);
echo '</div><!-- /.col -->';
echo '</div><!-- /.row -->';
echo '</div><!-- /.container -->';

echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-md-9">';
            /**
             * Contests
             */
            writeHtml("Results","h3");
            foreach ($xml->Election->ContestList->Contest as $contest) {
                writeHtml($contest['title'],'h5','contest-title');
                writeHtml("Total Ballots Cast: <strong>".$contest['ballotsCast']."</strong>");

                foreach($contest->Candidate as $candidate){
                    $percent = $candidate['votes']/$contest['ballotsCast'];

                    writeHtml($candidate['name'].": <strong>".$candidate['votes']."</strong> (".number_format( $percent * 100, 2 )."%)");
                }
            }
        } else {
            writeHtml($page_title,"h1","election-title");
            writeHtml("No election results found.","h3", "alert alert-warning");
        }

echo '</div><!-- /.col -->';
echo '<div class="col-md-3">';
?>
<nav class="hidden-print hidden-xs hidden-sm" id="sidebar">
    <ul class="nav">
        <li><a href="">Test</a></li>
        <li><a href="">Test</a></li>
        <li><a href="">Test</a></li>
    </ul>
</nav>
<?php
echo '</div><!-- /.col -->';
echo '</div><!-- /.row -->';
echo '</div><!-- /.container -->';

        /**
         * Dump a variable with a little HTML dressing for readability
         */
        function dd($string){
            echo '<pre>';
            var_dump($string);
            echo '</pre>';
            echo '<hr />';
        }

        /**
         * Dump a simple string into an HTML wrapper - tag defaults to <p>
         */
        function writeHtml($string, $tag = "p", $class = null, $id = null){
            echo "<".$tag;
            echo ($class ? ' class="'.$class.'"' : '');
            echo ($id ? ' id="'.$id.'"' : '');
            echo ">";
            echo $string;
            echo "</".$tag.">";
        }
        ?>

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
          <p class="copyright">Copyright Washington County 2016</p>
        </div><!-- /.row -->
      </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
$('#sidebar').affix({
      offset: {
        // top: $('header').height()
        top: 300
      }
});
    </script>
  </body>
</html>
