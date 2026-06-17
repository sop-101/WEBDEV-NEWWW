<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';

if (file_exists('email_api_config.php')) {
    include 'email_api_config.php';
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname   = trim($_POST['firstname'] ?? '');
    $lastname    = trim($_POST['lastname'] ?? '');
    $middlename  = trim($_POST['middlename'] ?? '');
    $suffix      = trim($_POST['suffix'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $password    = $_POST['password'] ?? '';
    $confirm_pwd = $_POST['confirm_password'] ?? '';

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_pwd)) {
        $error = "Please fill in all required fields.";
    } elseif ($password !== $confirm_pwd) {
        $error = "Password and Confirm Password do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $error = "This email address is already registered!";
        } else {
            $m_name = (!empty($middlename) && !isset($_POST['no_middle'])) ? $middlename . " " : "";
            $s_name = (!empty($suffix) && !isset($_POST['no_suffix'])) ? " " . $suffix : "";
            $fullname = trim($firstname . " " . $m_name . $lastname . $s_name);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $insert_stmt = $conn->prepare("INSERT INTO users (username, password, email, firstname, lastname, middlename, suffix, fullname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssssss", $email, $hashed_password, $email, $firstname, $lastname, $middlename, $suffix, $fullname);

            if ($insert_stmt->execute()) {
                $success = "Account created successfully! You can now log in.";
                $_POST = array(); 
            } else {
                $error = "An error occurred during registration: " . $conn->error;
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register_user.php">
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
                    <input type="checkbox" name="no_middle" <?php echo isset($_POST['no_middle']) ? 'checked' : ''; ?>> Not Applicable
                </label>
            </div>
            <div>
                <div class="form-group row-no-margin">
                    <label>Suffix</label>
                    <input type="text" name="suffix" placeholder="Example: Jr" value="<?php echo htmlspecialchars($_POST['suffix'] ?? ''); ?>">
                </div>
                <label class="sub-checkbox">
                    <input type="checkbox" name="no_suffix" <?php echo isset($_POST['no_suffix']) ? 'checked' : ''; ?>> Not Applicable
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
        <a href="login_user.php">Log In</a>
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
