
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
        background-color: #eceff1;
      }

      .navbar-default {
        background-color: #fff;
        border-bottom: 1px solid #aaa;
        box-shadow: 0 1px 1px rgba(0,0,0,0.10),0 2px 2px rgba(0,0,0,0.20);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
      }

      .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 0px;
        box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
      }

      .alert-warning {
        font-size: 1.25em;
        color: #000;
        background-color: #fff;
        border: 1px solid #ddd;
      }

      h1.election-title {
        font-family: 'Raleway';
        font-size: 2em;
        font-weight: 400;
        color: #001;
        margin-bottom: 1em;
      }

      p {
        font-size: 1.1em;
        line-height: 1.4em;
        color: #011;
        text-align: left;
      }

      .election-summary {
        min-height: 1em;
        padding: 1em;
        margin-bottom: 2em;
        border: 1px solid #ddd;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
      }

      .election-summary p {
        font-size: 1.2em;
        line-height: 1.3em;
      }
      .contest {
        border: 1px solid #ddd;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
      }

      .contest p {
        padding: .3em;
        margin: 0;
      }

      h5.contest-title {
        margin: 0;
        font-size: 1.4em;
        background-color: #ddd;
        padding: .5em;
      }

      .back-to-top {
        text-align: right;
        margin-bottom: 1em;
        padding-top: .5em;
        padding-bottom: .5em;
      }

      footer.footer {
        margin-top: 5em;
        padding: 2em 0 3em;
        background-color: #eee;
        background-image: linear-gradient(#fff, #eee);
      }

      .copyright {
        margin-top: 2em;
        text-align: center;
        font-weight: 300;
        color: #aaa;
      }

      #sidebar {
        border: 1px solid #ddd;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
      }

      h5.sidebar-title {
        margin: 0;
        padding: 10px 15px;
        font-size: 1.2em;
        font-weight: 600;
        background-color: #ddd;
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
          <a class="navbar-brand" href="/">[LOGO] Washington County Oregon Elections</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://www.co.washington.or.us/AssessmentTaxation/Elections/ElectionsArchive/index.cfm" target="_blank">Archives</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <a name="top"></a>
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

echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-md-4">';

echo '<nav class="hidden-print" id="sidebar">';
echo '<h5 class="sidebar-title">Contests</h5>';
echo '<ul class="nav">';
echo '<li><a href="#summary">Summary</a></li>';
foreach ($xml->Election->ContestList->Contest as $contest) {
  echo '<li><a href="#id-'.$contest['id'].'">'.$contest['title'].'</a></li>';
}
echo '</ul>';
echo '</nav>';

echo '</div><!-- /.col -->';
echo '<div class="col-md-8">';
echo '<a name="summary"></a>';
writeHtml("Summary","h3");

echo '<div class="election-summary">';
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
            /**
             * Contests
             */
            writeHtml("Results","h3");
            foreach ($xml->Election->ContestList->Contest as $contest) {
                echo '<a name="id-'.$contest['id'].'"></a>';
                echo '<div class="contest">';
                writeHtml($contest['title'],'h5','contest-title');
                writeHtml("Total Ballots Cast: <strong>".$contest['ballotsCast']."</strong>");

                foreach($contest->Candidate as $candidate){
                    $percent = $candidate['votes']/$contest['ballotsCast'];

                    writeHtml($candidate['name'].": <strong>".$candidate['votes']."</strong> (".number_format( $percent * 100, 2 )."%)");
                }
                echo '</div><!-- /.contest -->';
                echo '<div class="back-to-top"><a href="#top"><i class="fa fa-arrow-up"></i> back to top</a></div>';
            }
        } else {
            writeHtml($page_title,"h1","election-title");
            writeHtml("No election results found.","h3", "alert alert-warning");
        }

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
      $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
          if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
              $('html, body').animate({
                scrollTop: target.offset().top - 80
              }, 1000);
              return false;
            }
          }
        });
      });
    </script>
  </body>
</html>
