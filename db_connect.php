<?php

$host = "sql309.infinityfree.com";
$username = "if0_42187431";
$password = "WEBDEVGROUP2";
$database = "if0_42187431_surveydb";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

?>
