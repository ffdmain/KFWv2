<?php
$servername = "localhost"; // Replace with your database server name or IP address
$username = "root";     // Replace with your database username
$password = "";     // Replace with your database password
$database = "kfw";     // Replace with your database name

// Create a connection to the MySQL database
$db = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set character set to UTF-8 (if needed)
$db->set_charset("utf8");
?>
