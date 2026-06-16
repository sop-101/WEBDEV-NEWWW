<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PHP Test - Brgy 727</h2>";

// Test 1: Basic PHP
echo "<p>✅ PHP is working</p>";

// Test 2: Check if db_connect.php exists
if (file_exists('db_connect.php')) {
    echo "<p>✅ db_connect.php exists</p>";
} else {
    echo "<p>❌ db_connect.php NOT FOUND</p>";
    echo "<p>Files in directory: " . implode(", ", glob("*")) . "</p>";
    exit();
}

// Test 3: Include db_connect
echo "<p>Trying to include db_connect.php...</p>";
include 'db_connect.php';

// Test 4: Check connection
if (isset($conn) && $conn) {
    echo "<p>✅ Database connected successfully!</p>";

    // Test 5: Check tables
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        echo "<p>✅ Tables found:</p><ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Could not list tables: " . $conn->error . "</p>";
    }
} else {
    echo "<p>❌ Database connection failed</p>";
    if (isset($conn) && $conn->connect_error) {
        echo "<p>Error: " . $conn->connect_error . "</p>";
    }
}
?>