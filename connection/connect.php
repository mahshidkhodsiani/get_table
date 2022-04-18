<?php

$servername = "localhost";
$username = "root";
$password = "freemint";
$dbname = "local_1";

$conn = new mysqli($servername, $username ,$password , $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function Cfilter($a){
    global $conn;
    $b = $conn->real_escape_string($a);
    return $b;
}

/*
CONNECTION
*/