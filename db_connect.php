<?php

$host = "sql210.infinityfree.com";
$username = "if0_42204631";
$password = "WEBDEVGROUP2";
$database = "if0_42204631_surveydb";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

?>
