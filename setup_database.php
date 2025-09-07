<?php
// Database setup script
// This script will create the database and tables, and insert initial data

// Use the connection settings directly to ensure we connect properly
$servername = "localhost";
$username = "root";
$password = "";
$database = "project_checker";
$socket = "/opt/lampp/var/mysql/mysql.sock";

$link = new mysqli($servername, $username, $password, null, 3306, $socket);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Select database
$link->select_db($database);

// Read the schema file
$schema = file_get_contents('database/schema.sql');

// Split the schema into individual queries (excluding empty queries)
$queries = array_filter(array_map('trim', explode(';', $schema)));

// Execute each query
foreach ($queries as $query) {
    if (!empty($query)) {
        if ($link->query($query) === TRUE) {
            echo "Query executed successfully: " . substr($query, 0, 50) . "...\n";
        } else {
            echo "Error executing query: " . $link->error . "\n";
            echo "Query was: " . $query . "\n";
        }
    }
}

echo "Database setup completed.\n";
?>