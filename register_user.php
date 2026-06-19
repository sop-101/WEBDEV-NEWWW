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
    
    $no_middle   = isset($_POST['no_middle']);
    $no_suffix   = isset($_POST['no_suffix']);

    // Backend validation logic for required states
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_pwd)) {
        $error = "Please fill in all required fields.";
    } elseif (empty($middlename) && !$no_middle) {
        $error = "Please provide a Middle Name or check 'Not Applicable'.";
    } elseif (empty($suffix) && !$no_suffix) {
        $error = "Please provide a Suffix or check 'Not Applicable'.";
    } elseif ($password !== $confirm_pwd) {
        $error = "Password and Confirm Password do not match!";
    } else {
        // Enforce Password Requirements
        $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/';

        if (!preg_match($password_regex, $password)) {
            $error = "Password does not meet the requirements! It must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $error = "This email address is already registered!";
            } else {
                // Formulate full name based on checkbox status
                $m_name = (!empty($middlename) && !$no_middle) ? $middlename . " " : "";
                $s_name = (!empty($suffix) && !$no_suffix) ? " " . $suffix : "";
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

    <form method="POST" action="register_user.php" id="registrationForm">
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
                    <input type="text" id="middlename" name="middlename" placeholder="Middle Name" value="<?php echo htmlspecialchars($_POST['middlename'] ?? ''); ?>" required>
                </div>
                <label class="sub-checkbox">
                    <input type="checkbox" id="no_middle" name="no_middle" <?php echo isset($_POST['no_middle']) ? 'checked' : ''; ?>> Not Applicable
                </label>
            </div>
            <div>
                <div class="form-group row-no-margin">
                    <label>Suffix</label>
                    <input type="text" id="suffix" name="suffix" placeholder="Example: Jr" value="<?php echo htmlspecialchars($_POST['suffix'] ?? ''); ?>" required>
                </div>
                <label class="sub-checkbox">
                    <input type="checkbox" id="no_suffix" name="no_suffix" <?php echo isset($_POST['no_suffix']) ? 'checked' : ''; ?>> Not Applicable
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

document.addEventListener("DOMContentLoaded", function() {
    const middleInput = document.getElementById("middlename");
    const middleCheck = document.getElementById("no_middle");
    const suffixInput = document.getElementById("suffix");
    const suffixCheck = document.getElementById("no_suffix");

    function setupOptionalField(input, checkbox) {
        // Toggle input logic based on checkbox state
        function updateState() {
            if (checkbox.checked) {
                input.value = "";
                input.disabled = true;
                input.removeAttribute("required");
            } else {
                input.disabled = false;
                input.setAttribute("required", "required");
            }
        }

        checkbox.addEventListener("change", updateState);
        
        // If they start typing, make sure the checkbox unchecks
        input.addEventListener("input", function() {
            if (input.value.trim() !== "") {
                checkbox.checked = false;
                input.setAttribute("required", "required");
            }
        });

        // Initialize state on page load (useful if old values are retained)
        if (checkbox.checked) {
            updateState();
        } else if (input.value.trim() !== "") {
            checkbox.checked = false;
            input.setAttribute("required", "required");
        }
    }

    setupOptionalField(middleInput, middleCheck);
    setupOptionalField(suffixInput, suffixCheck);
});
</script>

</body>
</html>
