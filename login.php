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

            if (password_verify($password, $admin["password"])) {
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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            background: #fff;
            padding: 45px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-section h1 {
            color: #2c3e50;
            font-size: 34px;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .logo-section p {
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .login-container h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: .3s;
        }

        .form-group input:focus {
            border-color: #2c3e50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 62, 80, .12);
        }

        .show-password {
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .show-password input {
            margin-right: 8px;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .btn-login:hover {
            background: #1f2d3a;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="logo-section">
            <h1>BRGY 727</h1>
            <p>MONITORING SYSTEM</p>
        </div>

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
                    <input type="checkbox" onclick="togglePassword()">
                    Show Password
                </label>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>

        </form>

        <div class="back-link">
            <a href="homepage.php">← Back to Homepage</a>
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