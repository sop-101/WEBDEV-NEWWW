<?php
session_start();
include 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare("
            SELECT id, fullname, email, password
            FROM users
            WHERE email = ?
        ");

        if (!$stmt) {
            die("Database Error: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];

                header("Location: survey.php");
                exit();

            } else {

                $error = "Invalid email or password.";

            }

        } else {

            $error = "Invalid email or password.";

        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BRGY 727 - User Login</title>
<link rel="stylesheet" href="loginuser.css">
</head>
<body>

<div class="login-container">

    <div class="logo-section">

        <div class="logo-icon">
            ⚕
        </div>

        <h1>BRGY 727</h1>
        <p>Health Monitoring System</p>

    </div>

    <h2 class="login-title">User Login</h2>

    <p class="subtitle">
        Access community surveys and health records.
    </p>

    <?php if(!empty($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="form-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <div class="show-password">
            <input type="checkbox" id="showPassword">
            <label for="showPassword">
                Show Password
            </label>
        </div>

        <button type="submit" class="btn-login">
            Log In
        </button>

    </form>

    <div class="register-link">
        No account yet?
        <a href="register_user.php">
            Create Account
        </a>
    </div>

    <div class="admin-link">
        <a href="login.php">
            ← Admin Login
        </a>
    </div>

    <div class="login-footer">
        BRGY 727 Monitoring System
    </div>

</div>

<script>
document.getElementById("showPassword").addEventListener("change", function(){

    const password =
        document.getElementById("password");

    password.type =
        this.checked ? "text" : "password";

});
</script>

</body>
</html>
