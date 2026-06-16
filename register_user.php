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
    <link rel="stylesheet" href="register_user.css">   
</head>
<body>

    <div class="register-container">

    <div class="logo-section">
        <h1>BRGY 727</h1>
        <p>Health Monitoring System</p>
    </div>
    
    <h2>Create Account</h2>
    <p class="subtitle">Register to access the survey system.</p>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
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

        <div class="name-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" placeholder="First Name" required value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" placeholder="Last Name" required value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
            </div>
        </div>

        <div class="name-grid">
            <div>
                <div class="form-group row-no-margin">
                    <label>Middle Name</label>
                    <input type="text" name="middlename" placeholder="Middle Name" value="<?php echo htmlspecialchars($_POST['middlename'] ?? ''); ?>">
                </div>
                <label class="sub-checkbox">
                    <input type="checkbox" name="no_middle"> Not Applicable
                </label>
            </div>
            <div>
                <div class="form-group row-no-margin">
                    <label>Suffix</label>
                    <input type="text" name="suffix" placeholder="Example: Jr" value="<?php echo htmlspecialchars($_POST['suffix'] ?? ''); ?>">
                </div>
                <label class="sub-checkbox">
                    <input type="checkbox" name="no_suffix"> Not Applicable
                </label>
            </div>
        </div>

        <div class="form-group spacer-top">
            <label>Email Address</label>
            <input
                type="email"
                name="email"
                placeholder="Example: juandelacruz@gmail.com"
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

        <div class="form-group row-no-margin">
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
                Show Password
            </label>
        </div>

        <button type="submit" class="btn-register">Submit</button>

    </form>

    <div class="login-link">
        Already have an account?
        <a href="login.php">Log In</a>
    </div>

</div>

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