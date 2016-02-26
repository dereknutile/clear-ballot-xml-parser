<?php
namespace Washco;

class Election {
    // Full path to data import file
    public $import_file = '';

    // Full path to export HTML
    public $ouput_file = '';

    // if true, the class will erase the target export
    public $reset = false;

    public $partials_directory = '';
    public $partial = '';

    // This is the protected working string
    private $content = '';

    /**
     * Default constructor
     *
     * @return void
     */
    public function __construct(){
        if($this->reset){
            $this->reset_output_file();
        }
    }

    /**
     * Debug helper function
     * Dump a variable with a little HTML dressing for readability.
     *
     * @return string
     */
    public function dd($string){
        echo '<pre>';
        var_dump($string);
        echo '</pre>';
        echo '<hr />';
    }

    /**
     * Simple function to output html directly
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
     * Simple function that builds html and returns the string
     *
     * @return string
     */
    public function returnHtml($string, $tag = "p", $class = null, $id = null){
        $return  ='';
        $return .= "<".$tag;
        $return .= ($class ? ' class="'.$class.'"' : '');
        $return .= ($id ? ' id="'.$id.'"' : '');
        $return .= ">";
        $return .= $string;
        $return .= "</".$tag.">";
        return $return;
    }

    /**
     * Blanks or creates the target output file
     *
     * @return boolean
     */
    private function reset_output_file(){
        file_put_contents($this->ouput_file, '');
    }

    /**
     * Appends the contents of a partial file into the target file
     *
     * @return boolean
     */
    public function add_partial(){
        $content = file_get_contents($this->partial);
        file_put_contents($this->ouput_file, $content, FILE_APPEND);
    }

    /**
     * Appends a string into the target file
     *
     * @return boolean
     */
   public function write_string($input = null, $file = 'index.html'){
        if($input){
            $content = file_get_contents($input);
            file_put_contents($file, $content, FILE_APPEND);
        }
    }
}
?>