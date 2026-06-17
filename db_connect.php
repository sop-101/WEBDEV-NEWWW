<?php
$servername = "sql303.infinityfree.com";
$username = "if0_42193756";
$password = "yuna010625"; 
$dbname = "if0_42193756_brgy727_survey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
