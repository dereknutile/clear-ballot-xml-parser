<html>
    <head>
        <title>XML Parser</title>

        <link href='//fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                font-weight: 100;
                font-family: 'Roboto';
            }

            .container {
                margin-left: auto;
                margin-right: auto;
                width: 75%;
            }

            h1.election-title {
                padding-top: 1em;
                font-family: 'Raleway';
                font-size: 2em;
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
        </style>
    </head>

    <body>
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
                writeHtml($page_title,"h1","election-title");
                echo '<div class="election-summary">';
                writeHtml("Reporting","h2");

                /**
                 * Date and Time
                 */
                $report_time = $xml->ReportTime;
                $run_date = date('Y-m-d');
                $run_time = date('hh:mm:ss');
                if($report_time){
                    $exploded_report_time = explode("T", $report_time);
                    $run_date = $exploded_report_time[0];
                    $run_time = $exploded_report_time[1];
                }
                writeHtml("Run Date: ".$run_date);
                writeHtml("Run Time: ".$run_time);

                /**
                 * Reporting
                 */
                $precincts_reported = $election['precinctsReported'];
                $precincts_total = $election['totalPrecincts'];
                $precincts_percentage = $election['precinctsReportedPercentage'];
                writeHtml("Precincts Counted: ".$precincts_reported);
                writeHtml("Precincts Total: ".$precincts_total);
                writeHtml("Precincts Percentage: ".$precincts_percentage);
                $ballots_cast = $election['totalBallotsCast'];
                $ballots_registered = $election['totalRegistration'];
                $ballots_percentage = $election['totalCastPercentage'];
                writeHtml("Ballots Cast: ".$ballots_cast);
                writeHtml("Ballots Registered: ".$ballots_registered);
                writeHtml("Ballots Percentage: ".$ballots_percentage);

                echo "</div><!-- /.election-summary -->";

                /**
                 * Contests
                 */
                writeHtml("Contests","h4");
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
                writeHtml("No data found.","h3");
            }

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
    </body>
</html>
