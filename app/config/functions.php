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
    * Simple functiont to build and echo html
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