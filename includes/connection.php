<?php

$servername = "sql204.infinityfree.com";
$username = "if0_40558491";
$password = "j4895wDcV38hp";
$database = "if0_40558491_project_checker";

$link = new mysqli($servername, $username, $password, $database);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

?>