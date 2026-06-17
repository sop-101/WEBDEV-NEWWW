<?php
$servername = "sql300.infinityfree.com";
$username = "if0_42206978";
$password = "101106pup"; 
$dbname = "if0_42206978_brgy727_survey";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
