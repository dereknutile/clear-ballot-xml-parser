<?php
namespace Washco;

class Election {

    // Application variables
    public $appTitle = 'Washington County Election Results';
    public $logoUrl = '';

    // Full path to data import file
    public $importFile = '';

    // Full path to export HTML
    public $outputFile;

    // path to partials
    public $partialsDirectory;

    // This is the working string we use to build the output
    private $outputString = '';

    /**
     * Create a new generic Election object.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Appends the working output string
     *
     * @param string $string Content to append.
     *
     * @return void
     */
    private function appendOutputString($string){
        $this->outputString .= $string;
        $this->outputString .= "\r\n";
    }

    /**
     * Process the import xml file
     *
     * @return void
     */
    public function processImportFile(){
        // Set default page title just incase the XML is missing/unreadable
        $page_title = $this->appTitle;

        // Load the target xml file into an XML object using simplexml_load_file
        $xml = simplexml_load_file($this->importFile);

        if($xml){
            /**
             * Set election variables
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

            $this->appendOutputString('<div class="row">');
            $this->appendOutputString('<div class="col-md-3">');
            if(strlen($this->logoUrl)>0){
                $this->appendOutputString('<img src="'.$this->logoUrl.'" class="img-responsive img-center img-padded" />');
            }

            $this->appendOutputString('<nav class="hidden-print sidebar">');
            $this->appendOutputString('<h4 class="sidebar-heading">Contests</h4>');
            $this->appendOutputString('<ul class="list-unstyled">');
            $this->appendOutputString('<li><a href="#summary">Summary</a></li>');
            foreach ($xml->Election->ContestList->Contest as $contest) {
                $this->appendOutputString('<li><a href="#id-'.$contest['id'].'">'.$contest['title'].'</a></li>');
            }
            $this->appendOutputString('</ul>');
            $this->appendOutputString('</nav>');

            $this->appendOutputString('</div><!-- /.col -->');
            $this->appendOutputString('<div class="col-md-9">');
            $this->appendOutputString('<div class="page-header">');
            $this->appendOutputString('<h1>'.$page_title.'</h1>');
            $this->appendOutputString('</div>');
            $this->appendOutputString('<h2>Unofficial Results</h2>');
            if($this->nextTime){
                $this->appendOutputString('<p class="alert alert-warning">Next run time: '.$this->nextTime.'</p>');
            }
            $this->appendOutputString('<a name="summary"></a>');
            $this->appendOutputString('<h3>Summary</h3>');

            $this->appendOutputString('<div class="election-summary">');
            $this->appendOutputString('<div class="row">');
            $this->appendOutputString('<div class="col-md-4">');
            $this->appendOutputString('<p>Run Date: '.$run_date.'</p>');
            $this->appendOutputString('<p>Run Time: '.$run_time.'</p>');
            $this->appendOutputString('</div><!-- /.col -->');


            $precincts_reported = $election['precinctsReported'];
            $precincts_total = $election['totalPrecincts'];
            $precincts_percentage = $election['precinctsReportedPercentage'];

            $this->appendOutputString('<div class="col-md-4">');
            $this->appendOutputString('<p>Precincts Total: '.$precincts_total.'</p>');
            $this->appendOutputString('<p>Precincts Counted: '.$precincts_reported.'</p>');
            $this->appendOutputString('<p>Precincts Percentage: '.$precincts_percentage.'</p>');
            $this->appendOutputString('</div><!-- /.col -->');

            $ballots_cast = $election['totalBallotsCast'];
            $ballots_registered = $election['totalRegistration'];
            $ballots_percentage = $election['totalCastPercentage'];
            $this->appendOutputString('<div class="col-md-4">');
            $this->appendOutputString('<p>Ballots Cast: '.$ballots_cast.'</p>');
            $this->appendOutputString('<p>Ballots Registered: '.$ballots_registered.'</p>');
            $this->appendOutputString('<p>Ballots Percentage: '.$ballots_percentage.'</p>');
            $this->appendOutputString('</div><!-- /.col -->');
            $this->appendOutputString('</div><!-- /.row -->');
            $this->appendOutputString('</div><!-- /.container -->');

            /**
             * Contests
             */
            $this->appendOutputString('<h3>Results</h3>');
            foreach ($xml->Election->ContestList->Contest as $contest) {
                $this->appendOutputString('<a name="id-'.$contest['id'].'"></a>');
                $this->appendOutputString('<div class="contest">');
                $this->appendOutputString('<h5 class="contest-title">'.$contest['title'].'</h5>');
                $this->appendOutputString('<p>Total Ballots Cast: <strong>'.$contest['ballotsCast'].'</strong></p>');

                foreach($contest->Candidate as $candidate){
                    $percent = $candidate['votes']/$contest['ballotsCast'];
                    $this->appendOutputString('<p>'.$candidate['name'].": <strong>".$candidate['votes']."</strong> (".number_format( $percent * 100, 2 )."%)</p>");
                }
                $this->appendOutputString('</div><!-- /.contest -->');
                $this->appendOutputString('<div class="back-to-top"><a href="#top"><i class="fa fa-arrow-up"></i> back to top</a></div>');
            }
        } else {
            if(strlen($this->logoUrl)>0){
                $this->appendOutputString('<img src="'.$this->logoUrl.'" class="img-responsive img-center" />');
            }
            $this->appendOutputString('<h1 class="election-title">'.$page_title.'</h1>');
            $this->appendOutputString("No election results found.","h3", "alert alert-warning");
        }

        $this->appendOutputString('</div><!-- /.col -->');
        $this->appendOutputString('</div><!-- /.row -->');
    }

    /**
     * Appends the contents of a partial file into the target file
     *
     * @param string $file Required name of file to append the contents of
     *
     * @return boolean
     */
    public function addPartial($file){
        $this->appendOutputString(file_get_contents($this->partialsDirectory.$file));
    }

    /**
     * Appends a string into the target file
     *
     * @param string $string String to append to $this->outputString
     *
     * @return boolean
     */
    public function addString($string){
        $this->appendOutputString($string);
    }

    /**
     * Writes content to the output file
     *
     * @param boolean $append If true appends the output file
     *
     * @return boolean
     */
    public function writeOutputFile($append = true){
        if($append){
            file_put_contents($this->outputFile, $this->outputString, FILE_APPEND);
        } else {
            file_put_contents($this->outputFile, $this->outputString);
        }
    }

    /**
     * Debug helper function
     * Dump a variable with a little HTML dressing for readability.
     *
     * @param string $string String to ouput
     * @param boolean $die If true, throws a die()
     *
     * @return string
     */
    public function dd($string = '', $die = true){
        echo '<pre>';
        var_dump($string);
        echo '</pre>';
        if($die){
            die();
        } else {
            echo '<hr />';
        }
    }

    /**
     * Simple function to output html directly
     *
     * @param string $string Content to append.
     * @param string $tag Optional tag, defaults to <p>
     * @param string $class Optional class
     * @param string $id Optional id
     *
     * @return string
     */
    public function writeHtml($string, $tag = "p", $class = null, $id = null){
        echo "<".$tag;
        echo ($class ? ' class="'.$class.'"' : '');
        echo ($id ? ' id="'.$id.'"' : '');
        echo ">";
        echo $string;
        echo "</".$tag.">";
    }
}
?>