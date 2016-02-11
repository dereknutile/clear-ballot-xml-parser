<html>
    <head>
        <title>XML Parser</title>

        <link href='//fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                color: #aaa;
                font-weight: 100;
                font-family: 'Roboto';
            }

            .container {
                margin-left: auto;
                margin-right: auto;
                width: 75%;
            }

            .title {
                padding-top: 1em;
                font-family: 'Raleway';
                font-size: 3em;
                color: #001;
                margin-bottom: 1em;
            }

            p {
                font-size: 1.3em;
                line-height: 2em;
                color: #011;
                text-align: left;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="title"><?php echo "Title"; ?></div>

            <?php

            // Set a variable for the source data directory
            $data_directory = __DIR__.'/../data';

            // Load the target xml file into an XML object using simplexml_load_file
            $xml = simplexml_load_file($data_directory.'/import.xml' );

            // Iterate
            foreach ($xml->GroupMap->Group as $group) {
                putp("The group named <b>".$group['name']."</b> has an ID of <b>".$group['id']."</b>.");
            }

            // Dump a variable with a little HTML dressing for readability
            function dd($string){
                echo '<pre>';
                var_dump($string);
                echo '</pre>';
                echo '<hr />';
            }

            // Dump a simple string into a paragraph HTML wrapper
            function putp($string){
                echo "<p>";
                echo $string;
                echo "</p>";
            }
            ?>

        </div><!-- /.container -->
    </body>
</html>
