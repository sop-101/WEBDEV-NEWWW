<?php
include 'db_connect.php';

$user = 'brgyadmin';
$plain_password = '@brgy717!';

// This generates a fresh hash using your server's exact configuration
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?) ON DUPLICATE KEY UPDATE password = ?");
$stmt->bind_param("sss", $user, $hashed_password, $hashed_password);

if ($stmt->execute()) {
    echo "Successfully created or updated admin account: <b>" . $user . "</b>!";
} else {
    echo "Error inserting account: " . $conn->error;
}

$stmt->close();
?>
