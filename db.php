<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$db = "dba51xo53mfafj";
$user = "utatmdw3avnr4";
$pass = "e2z32i3bK~u@";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");
