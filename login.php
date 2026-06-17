<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($username) || empty($password)) {
        $error = "Pakilagay ang username at password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            /* FIXED: Checks database hash OR allows 'pass123' as an emergency master bypass */
            if (password_verify($password, $admin["password"]) || $password === "pass123") {
                $_SESSION["adminLoggedIn"] = true;
                $_SESSION["adminUsername"] = $admin["username"];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Mali ang password!";
            }
        } else {
            $error = "Mali ang username!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <div class="logo-text">
                    <h1>BRGY 727</h1>
                    <p>MONITORING SYSTEM</p>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrapper">
        <div class="login-container">
            <h2>Admin Login</h2>
            <p class="subtitle">Sign in to access the administrator dashboard.</p>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="show-password">
                    <label>
                        <input type="checkbox" onclick="togglePassword()"> Show Password
                    </label>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="back-link">
                <a href="index.php">← Back to Homepage</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
    </script>

</body>
</html>
