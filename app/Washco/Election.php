<?php
namespace Washco;

class Election {

    // Application variables
    public $appTitle = 'Washington County Election Results';
    public $logoUrl = '';

    // path to the /public web directory
    public $publicDirectory = '';

    // Full path to data input directory
    public $inputDirectory = '';

    // Name of the input file
    public $inputFile = '';

    // Full path to data output directory
    public $outputDirectory = '';

    // Name of the output HTML
    public $outputFile = '';

    // timestamp for prefixing files
    public $timeStamp = null;

    // path to partials
    public $partialsDirectory = '';

    // path to processed files directory
    public $processedDirectory = '';

    // posted variables
    public $postStatus = 'none';
    public $postDate = null;
    public $postTime = null;

    // Array of XML files read from the input directory
    // private $xmlFiles = array();

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
    public function processInputFile(){
        // Set default page title just incase the XML is missing/unreadable
        $page_title = $this->appTitle;

        // Load the target xml file into an XML object using simplexml_load_file
        $xml = simplexml_load_file($this->inputDirectory.$this->inputFile);

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

            $this->appendOutputString('<div class="container">');
            $this->appendOutputString('<div class="row">');
            $this->appendOutputString('<div class="col-md-3">');
            if(strlen($this->logoUrl)>0){
                $this->appendOutputString('<img src="'.$this->logoUrl.'" class="img-responsive img-center img-padded" />');
            }
            $this->appendOutputString('</div><!-- /.col -->');

            $this->appendOutputString('<div class="col-md-9">');
            $this->appendOutputString('<div class="page-header">');
            $this->appendOutputString('<h1>'.$page_title.'</h1>');
            $this->appendOutputString('</div>');
            if($this->nextTime){
                $this->appendOutputString('<p class="alert alert-warning">Next run time: '.$this->nextTime.'</p>');
            }
            $this->appendOutputString('</div><!-- /.col -->');
            $this->appendOutputString('</div><!-- /.row -->');
            $this->appendOutputString('</div><!-- /.container -->');

            if($this->postStatus !== 'none'){
                $this->appendOutputString('<div class="election-status">');
                $this->appendOutputString('<div class="container">');
                if($this->postStatus == 'official'){
                    $this->appendOutputString('<p class="election-status-copy">Washington County Final Election Results</p>');
                }
                if($this->postStatus == 'unofficial'){
                    $this->appendOutputString('<p class="election-status-copy">Unofficial Washington County Election Results</p>');
                }
                if($this->postDate or ($this->postTime and $this->postTime !== 'none')){
                    $this->appendOutputString('<p class="election-status-copy">Next update ');
                    if($this->postDate){
                        $this->appendOutputString(' on '.$this->postDate);
                    }
                    if($this->postTime and $this->postTime !== 'none'){
                        $this->appendOutputString(' at '.date("g:i A", strtotime($this->postTime.":00")));
                    }
                    $this->appendOutputString('</p>');
                }
                $this->appendOutputString('</div>');
                $this->appendOutputString('</div>');
            }

            $this->appendOutputString('<div class="container add-top-padding">');
            $this->appendOutputString('<div class="row">');
            $this->appendOutputString('<div class="col-md-3">');
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
        $this->appendOutputString('</div><!-- /.container -->');
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
     * @return void
     */
    public function addString($string){
        $this->appendOutputString($string);
    }

    /**
     * Writes content to the output file
     *
     * @param boolean $preview Copies the processed output file to preview.html
     *
     * @return void
     */
    public function writeOutputFile($preview = true){
        file_put_contents($this->outputDirectory.$this->outputFile, $this->outputString);
        copy($this->outputDirectory.$this->outputFile, $this->processedDirectory.'html/'.$this->timeStamp.'-'.$this->outputFile);
        if($preview){
            $this->writePreviewFile();
        }
    }

    /**
     * Copies the processed output file to preview.html
     *
     * @param string $file_name Name of the destination preview file
     *
     * @return void
     *
     */
    public function writePreviewFile($file_name = 'preview.html'){
        file_put_contents($this->publicDirectory.$file_name, $this->outputString);
    }

    /**
     * Moves the processed XML file to the processed/xml directory with a prefix
     * like year-mm-dd-hh-mm-ss-input.xml
     *
     * @return boolean
     *
     */
    public function archiveXmlFile(){
        $return = false;
        if (rename($this->inputDirectory.$this->inputFile, $this->processedDirectory.'xml/'.$this->timeStamp.'-'.$this->inputFile)) {
            $return = true;
        }
        return $return;
    }

    /**
     * Finds all xml files in the data directory
     *
     * @return string
     */
    public function findXmlFiles ()
    {
        $output = array();
        $files = scandir($this->inputDirectory);

        if($files){
            foreach($files as $file){
                // remove the hidden and system files from results
                if(!in_array($file, array(".","..",".DS_Store",".gitignore"))){
                    $output[] = $file;
                }
            }
        }

        return $output;
    }

    /**
     * Finds all xml files in the data directory
     *
     * @param array $xml is the array of xml files
     * @return string
     */
    public function buildXmlFormContent ($xml = null)
    {
        if($xml){
            $counter = 1;
            $this->appendOutputString('<h3>'.count($xml).' XML file(s) found!</h3>');
            foreach($xml as $file){
                $size = filesize($this->inputDirectory.$file);
                $this->appendOutputString('<div class="input-file">');
                $this->appendOutputString('<form action="process.php" method="post" id="form-'.$counter.'">');
                $this->appendOutputString('<h5 class="input-file-title"><i class="fa fa-file-text"></i>&nbsp;'.urldecode($file).'<small >'.sprintf("%.2f", ($size / 1000)/1000).'mb</small></h5>');

                $this->appendOutputString('<div class="form-group">');
                $this->appendOutputString('<label for="status" class="control-label">Choose a Status Banner</label>');
                $this->appendOutputString('<select name="status" class="form-control">');
                $this->appendOutputString('<option value="unofficial">Unofficial Results Banner</option>');
                $this->appendOutputString('<option value="official">Final Results Banner</option>');
                $this->appendOutputString('<option value="none">No Banner Displayed</option>');
                $this->appendOutputString('</select>');
                $this->appendOutputString('</div><!-- /.form-group -->');

                $this->appendOutputString('<div class="form-group">');
                $this->appendOutputString('<label for="time" class="control-label">Next Update Day (optional)</label>');
                $this->appendOutputString('<input type="text" class="form-control" name="date" placeholder="Thursday, November, 7">');
                $this->appendOutputString('</div><!-- /.form-group -->');

                $this->appendOutputString('<div class="form-group">');
                $this->appendOutputString('<label for="time" class="control-label">Next Update Time (optional)</label>');
                $this->appendOutputString('<select name="time" class="form-control">');
                $this->appendOutputString('<option value="none">None</option>');
                $this->appendOutputString($this->buildTimeDropper());
                $this->appendOutputString('</select>');
                $this->appendOutputString('</div><!-- /.form-group -->');

                $this->appendOutputString('<div class="input-file-actions">');
                $this->appendOutputString('<input type="hidden" name="file" value="'.htmlentities($file).'">');
                $this->appendOutputString('<button type="submit" class="btn btn-primary"><i class="fa fa-cogs"></i>&nbsp;Process</button>');
                $this->appendOutputString('</div><!-- /.input-file-actions -->');
                $this->appendOutputString('</form>');
                $this->appendOutputString('</div><!-- /.input-file -->');
                $counter++;
            }
        } else {
            $this->outputString = '<h3>No XML file(s) found!</h3>';
        }

        return $this->outputString;
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

    /**
     * Builds a time drop-down
     *
     * @return string
     */
    private function buildTimeDropper ()
    {
        $output = '';

        for($i = 0; $i < 24; $i++){
            $value = date("g:i A", strtotime("$i:00"));
            $output .= '<option value="'.$i.'">'.$value.'</option>';
        }

        return $output;
    }
}
?>