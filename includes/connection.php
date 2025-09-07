<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "project_checker";
$socket = "/opt/lampp/var/mysql/mysql.sock";

$link = new mysqli($servername, $username, $password, $database, 3306, $socket);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

?>