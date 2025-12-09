<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "project_checker";

$link = new mysqli($servername, $username, $password, $database);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

?>
