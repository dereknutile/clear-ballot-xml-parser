<?php
$file = 'test.html';
// Open the file to get existing content
$index = file_get_contents( 'index.php' );
// Append a new person to the file
$index .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $index);
?>