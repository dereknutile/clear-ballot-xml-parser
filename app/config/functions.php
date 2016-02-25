<?php

    /**
    * Debug function
    * Dump a variable with a little HTML dressing for readability.
    */
    function dd($string){
        echo '<pre>';
        var_dump($string);
        echo '</pre>';
        echo '<hr />';
    }

    /**
    * Simple function to output html
    */
    function writeHtml($string, $tag = "p", $class = null, $id = null){
        echo "<".$tag;
        echo ($class ? ' class="'.$class.'"' : '');
        echo ($id ? ' id="'.$id.'"' : '');
        echo ">";
        echo $string;
        echo "</".$tag.">";
    }

    /**
    * Simple function that builds html and returns the string
    */
    function returnHtml($string, $tag = "p", $class = null, $id = null){
        $return  ='';
        $return .= "<".$tag;
        $return .= ($class ? ' class="'.$class.'"' : '');
        $return .= ($id ? ' id="'.$id.'"' : '');
        $return .= ">";
        $return .= $string;
        $return .= "</".$tag.">";
        return $return;
    }

    function make_file($file = 'index.html'){
        file_put_contents($file,'hi');
    }

    // file_put_contents($file, $index);
    // FILE_APPEND | LOCK_EX

?>