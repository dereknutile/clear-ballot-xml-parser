<!-- Start content partial -->

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
                    <a class="navbar-brand" href="/"><img src="http://placehold.it/50/0099d7/ffffff/?text=W" /> Washington County Election Results</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://www.co.washington.or.us/" target="_blank">County Website</a></li>
                        <li><a href="http://www.co.washington.or.us/assessmenttaxation/elections" target="_blank">Elections</a></li>
                        <li><a href="http://www.co.washington.or.us/AssessmentTaxation/Elections/ElectionsArchive" target="_blank">Archives</a></li>
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
                ?>

                </div><!-- /.container -->
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

<!-- End content partial -->
