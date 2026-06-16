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

    <style>
        body{
            font-family: "Segoe UI", sans-serif;
            background:#f4f6f9;
        }

        .register-container{
    max-width:750px; /* wider */
    margin:50px auto;
    background:#fff;
    padding:50px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}

.logo-section{
    text-align:center;
    margin-bottom:30px;
}

.logo-section h1{
    font-size:36px;
    color:#1a1a2e;
    font-weight:700;
    letter-spacing:1px;
    margin-bottom:5px;
}

.logo-section p{
    font-size:15px;
    color:#666;
    text-transform:uppercase;
    letter-spacing:2px;
}
        .register-container h2{
            text-align:center;
            color:#1a1a2e;
            margin-bottom:10px;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-bottom:25px;
            font-size:14px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group label{
            display:block;
            margin-bottom:6px;
            font-weight:600;
            color:#333;
        }

       .form-group input{
    width:100%;
    padding:14px;
    border:2px solid #e0e0e0;
    border-radius:8px;
    font-size:15px;
    transition:0.3s;
}

        .form-group input:focus{
    border-color:#e94560;
    outline:none;
    box-shadow:0 0 0 3px rgba(233,69,96,.15);
}
.btn-register{
    width:100%;
    padding:16px;
    background:#e94560;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}
        .password-requirements{
            background:#f8f9fa;
            border-left:4px solid #e94560;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
            font-size:13px;
            color:#555;
        }

        .password-requirements strong{
            display:block;
            margin-bottom:8px;
            color:#333;
        }

        .password-requirements ul{
            margin-left:18px;
        }

        .password-requirements li{
            margin-bottom:4px;
        }

        .btn-register{
            width:100%;
            padding:14px;
            background:#e94560;
            color:white;
            border:none;
            border-radius:8px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .btn-register:hover{
            background:#c93650;
        }

        .login-link{
            text-align:center;
            margin-top:20px;
            color:#666;
            font-size:14px;
        }

        .login-link a{
            color:#e94560;
            text-decoration:none;
            font-weight:600;
        }

        .login-link a:hover{
            text-decoration:underline;
        }

        .error-message{
            background:#f8d7da;
            color:#721c24;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        }

        .success-message{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        }
        .show-password-option{
    margin-bottom:20px;
    font-size:14px;
    color:#555;
}

.show-password-option input{
    margin-right:8px;
}
    </style>
</head>

    
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