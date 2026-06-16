<?php
session_start();
include 'db_connect.php';
include 'email_api_config.php';

/* ALL YOUR CURRENT PHP CODE HERE */

$error = "";
$success = "";

/* validation code */

?>

<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Brgy 727</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="registeruser.css">   
<body>

<div class="register-container">

    <div class="logo-section">
    <h1>BRGY 727</h1>
    <p>MONITORING SYSTEM</p>
</div>
    <h2>Create Account</h2>

    <p class="subtitle">
        Register to access the survey system.
    </p>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register_user.php">

        <div class="form-group">
            <label>Full Name</label>
            <input
                type="text"
                name="fullname"
                placeholder="Enter full name"
                required
                value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>"
            >
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input
                type="email"
                name="email"
                placeholder="example@email.com"
                required
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
            >
        </div>

       <div class="password-requirements">
    <strong>Password Requirements</strong>
    <ul>
        <li>Minimum 8 characters</li>
        <li>At least one uppercase letter</li>
        <li>At least one lowercase letter</li>
        <li>At least one number</li>
        <li>At least one special character</li>
    </ul>
</div>

<div class="form-group">
    <label>Password</label>
    <input
        type="password"
        id="password"
        name="password"
        placeholder="Create a password"
        required
    >
</div>

<div class="form-group">
    <label>Confirm Password</label>
    <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        placeholder="Confirm your password"
        required
    >
</div>

<div class="show-password-option">
    <label>
        <input type="checkbox" onclick="togglePasswords()">
        Show Passwords
    </label>
    
     <button type="submit" class="btn-register">SUBMIT</button>
</div>

    </form>

    <div class="login-link">
        Already have an account?
        <a href="login_user.php">Log In</a>
    </div>

</div>

</body>
    <script>
function togglePasswords() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    if (password.type === "password") {
        password.type = "text";
        confirmPassword.type = "text";
    } else {
        password.type = "password";
        confirmPassword.type = "password";
    }
}
</script>

</body>
</html>
