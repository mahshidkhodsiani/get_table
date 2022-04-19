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


function fetch_query($sql){
    global $conn ;
    $data = array();
    $res = $conn->query($sql);  
    if ($res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row; 
        }
    }
    
    return $data ;
}

/*
CONNECTION
*/