<?php
$filename = 'players.json';

if (file_exists($filename)) {
    echo "File '$filename' exists!<br>";
    echo "Contents:<br>";
    echo nl2br(file_get_contents($filename));
} else {
    echo "File '$filename' does NOT exist!";
}
?>
