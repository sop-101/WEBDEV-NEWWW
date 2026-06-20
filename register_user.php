<?php
session_start();
include 'db_connect.php';

$error = "";
$success = "";

// Step 2: After verification, create the account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verified_email'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['verified_email']);
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, verified) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sss", $fullname, $email, $hashed);
        
        if ($stmt->execute()) {
            $success = "Account created successfully! You can now log in.";
            unset($_SESSION['pending_reg']);
        } else {
            $error = "Failed to create account. Please try again.";
        }
    }
}
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
        <p>MONITORING SYSTEM</p>
    </div>
    <h2>Create Account</h2>
    <p class="subtitle">Register to access the survey system.</p>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <!-- Step 1: Registration Form -->
    <form id="registerForm" method="POST" action="register_user.php" style="<?php echo !empty($success) ? 'display:none;' : ''; ?>">
        
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" id="email" name="email" placeholder="you@gmail.com" required>
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
            <input type="password" id="password" name="password" placeholder="Create a password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
        </div>

        <div class="show-password-option">
            <label><input type="checkbox" onclick="togglePasswords()"> Show Passwords</label>
        </div>

        <!-- Hidden field for verified email -->
        <input type="hidden" id="verified_email" name="verified_email">

        <button type="button" class="btn-register" id="registerBtn" onclick="startVerification()">
            Register Account
        </button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login_user.php">Log In</a>
    </div>
</div>

<!-- Verification Popup -->
<div class="verify-overlay" id="verifyOverlay">
    <div class="verify-box">
        <h3>Verify Your Gmail</h3>
        <p>We sent a 6-digit code to <strong id="sentEmail"></strong></p>
        <input type="text" id="codeInput" placeholder="123456" maxlength="6" inputmode="numeric">
        <div class="timer" id="timer"></div>
        <button onclick="verifyCode()">Verify Code</button>
        <button class="secondary" onclick="resendCode()">Resend Code</button>
        <button class="cancel" onclick="closeVerify()">Cancel</button>
        <div class="message" id="verifyMsg"></div>
    </div>
</div>

<!-- EmailJS SDK -->
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script>
// ═══════════════════════════════════════════════════════
// ║  CONFIG - REPLACE THESE 3 VALUES WITH YOUR EMAILJS   ║
// ═══════════════════════════════════════════════════════

const EMAILJS_PUBLIC_KEY = 'BVp0bsl2EjFje3EfH';
const EMAILJS_SERVICE_ID = 'service_u4ydqro';
const EMAILJS_TEMPLATE_ID = 'template_sgla6cn';

// ═══════════════════════════════════════════════════════

emailjs.init(EMAILJS_PUBLIC_KEY);

// ==================== PASSWORD VALIDATION ====================
function validatePassword(pwd) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;
    return regex.test(pwd);
}

function togglePasswords() {
    const p1 = document.getElementById("password");
    const p2 = document.getElementById("confirm_password");
    const type = p1.type === "password" ? "text" : "password";
    p1.type = type;
    p2.type = type;
}

// ==================== EMAIL VALIDATION ====================
const fakePatterns = [
    /^test@/i, /^fake@/i, /^admin@/i, /^noreply@/i,
    /^example@/i, /^user@/i, /^demo@/i, /^sample@/i,
    /^(abc|123|qwerty|asdf|zxcv|password|temp|tmp|junk|spam|bot)/i,
    /(.)\1{4,}/,
    /^(none|null|undefined|empty|nobody|someone|anyone)/i
];

const disposableDomains = [
    'tempmail.com','10minutemail.com','guerrillamail.com',
    'mailinator.com','yopmail.com','throwawaymail.com',
    'temp-mail.org','fakeinbox.com','sharklasers.com'
];

function isValidGmail(email) {
    if (!email || !email.endsWith('@gmail.com')) {
        return { valid: false, reason: 'Only Gmail addresses are allowed' };
    }
    const local = email.split('@')[0];
    if (local.length < 6) return { valid: false, reason: 'Gmail username too short (min 6 chars)' };
    if (local.length > 30) return { valid: false, reason: 'Gmail username too long (max 30 chars)' };
    if (local.includes('..')) return { valid: false, reason: 'Gmail cannot contain consecutive dots' };
    if (local.startsWith('.') || local.endsWith('.')) return { valid: false, reason: 'Gmail cannot start or end with a dot' };
    for (const pattern of fakePatterns) {
        if (pattern.test(email)) return { valid: false, reason: 'This email pattern is not allowed' };
    }
    const domain = email.split('@')[1].toLowerCase();
    if (disposableDomains.includes(domain)) return { valid: false, reason: 'Disposable emails are not allowed' };
    return { valid: true };
}

// ==================== RATE LIMITING ====================
const RATE_LIMIT_KEY = 'email_verify_attempts';
const MAX_ATTEMPTS = 5;
const WINDOW_MS = 60 * 60 * 1000; // 1 hour

function checkRateLimit(email) {
    const domain = email.split('@')[1];
    const now = Date.now();
    const attempts = JSON.parse(localStorage.getItem(RATE_LIMIT_KEY) || '{}');
    const userAttempts = attempts[domain] || [];
    const recent = userAttempts.filter(t => now - t < WINDOW_MS);
    if (recent.length >= MAX_ATTEMPTS) {
        const oldest = recent[0];
        const waitMinutes = Math.ceil((WINDOW_MS - (now - oldest)) / 60000);
        return { allowed: false, waitMinutes };
    }
    recent.push(now);
    attempts[domain] = recent;
    localStorage.setItem(RATE_LIMIT_KEY, JSON.stringify(attempts));
    return { allowed: true };
}

// ==================== VERIFICATION LOGIC ====================
let currentCode = null;
let currentEmail = null;
let expiryTime = null;

function generateCode() {
    return Math.floor(100000 + Math.random() * 900000).toString();
}

function storeVerification(email, code) {
    currentCode = code;
    currentEmail = email;
    expiryTime = Date.now() + 15 * 60 * 1000; // 15 minutes
    sessionStorage.setItem('verify_email', email);
    sessionStorage.setItem('verify_code', code);
    sessionStorage.setItem('verify_expiry', expiryTime);
}

function getStoredVerification() {
    if (currentCode) return { email: currentEmail, code: currentCode, expiry: expiryTime };
    const email = sessionStorage.getItem('verify_email');
    const code = sessionStorage.getItem('verify_code');
    const expiry = parseInt(sessionStorage.getItem('verify_expiry'));
    if (email && code && expiry) {
        currentEmail = email;
        currentCode = code;
        expiryTime = expiry;
        return { email, code, expiry };
    }
    return null;
}

function clearVerification() {
    currentCode = null;
    currentEmail = null;
    expiryTime = null;
    sessionStorage.removeItem('verify_email');
    sessionStorage.removeItem('verify_code');
    sessionStorage.removeItem('verify_expiry');
}

// ==================== UI HELPERS ====================
function showVerifyMsg(text, type) {
    const el = document.getElementById('verifyMsg');
    el.textContent = text;
    el.className = 'message show ' + type;
}

function showOverlay(show) {
    document.getElementById('verifyOverlay').classList.toggle('active', show);
}

function setInputError(id, isError) {
    const input = document.getElementById(id);
    input.className = isError ? 'error' : (isError === false ? 'success' : '');
}

// ==================== MAIN FLOW ====================
function startVerification() {
    const fullname = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim().toLowerCase();
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;

    // Clear previous errors
    ['fullname', 'email', 'password', 'confirm_password'].forEach(id => setInputError(id, null));

    // Validate all fields
    if (!fullname) {
        setInputError('fullname', true);
        alert('Please enter your full name');
        return;
    }

    const emailCheck = isValidGmail(email);
    if (!emailCheck.valid) {
        setInputError('email', true);
        alert(emailCheck.reason);
        return;
    }

    if (!validatePassword(password)) {
        setInputError('password', true);
        alert('Password does not meet requirements');
        return;
    }

    if (password !== confirm) {
        setInputError('password', true);
        setInputError('confirm_password', true);
        alert('Passwords do not match');
        return;
    }

    // Rate limit check
    const rateCheck = checkRateLimit(email);
    if (!rateCheck.allowed) {
        alert('Too many attempts. Try again in ' + rateCheck.waitMinutes + ' minutes.');
        return;
    }

    // Generate and send code
    const code = generateCode();
    storeVerification(email, code);

    document.getElementById('registerBtn').disabled = true;
    document.getElementById('registerBtn').textContent = 'Sending...';

    emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_TEMPLATE_ID, {
        to_email: email,
        passcode: code,              // ✅ FIXED: matches {{passcode}} in template
        from_name: 'BRGY 727 Monitoring System'
    }).then(() => {
        document.getElementById('sentEmail').textContent = email;
        document.getElementById('registerBtn').textContent = 'Register Account';
        showOverlay(true);
        startTimer();
    }).catch(err => {
        console.error('EmailJS Error:', err);
        alert('Failed to send verification code. Please try again.');
        document.getElementById('registerBtn').disabled = false;
        document.getElementById('registerBtn').textContent = 'Register Account';
        clearVerification();
    });
}

function verifyCode() {
    const input = document.getElementById('codeInput').value.trim();
    const stored = getStoredVerification();

    showVerifyMsg('', '');

    if (!stored) {
        showVerifyMsg('Session expired. Please start over.', 'error');
        return;
    }

    if (Date.now() > stored.expiry) {
        showVerifyMsg('Code expired. Please request a new one.', 'error');
        clearVerification();
        return;
    }

    if (input !== stored.code) {
        showVerifyMsg('Invalid code. Please check and try again.', 'error');
        document.getElementById('codeInput').style.borderColor = '#ef4444';
        setTimeout(() => document.getElementById('codeInput').style.borderColor = '#e0e0e0', 400);
        return;
    }

    // SUCCESS! Submit form to PHP
    clearVerification();
    document.getElementById('verified_email').value = stored.email;
    document.getElementById('registerForm').submit();
}

function resendCode() {
    const stored = getStoredVerification();
    if (!stored) {
        closeVerify();
        return;
    }
    currentEmail = stored.email;
    startVerification();
}

function closeVerify() {
    showOverlay(false);
    document.getElementById('registerBtn').disabled = false;
    clearVerification();
}

function startTimer() {
    const timerEl = document.getElementById('timer');
    const stored = getStoredVerification();
    if (!stored) return;

    const interval = setInterval(() => {
        const remaining = Math.ceil((stored.expiry - Date.now()) / 1000);
        if (remaining <= 0) {
            clearInterval(interval);
            timerEl.textContent = 'Code expired';
            clearVerification();
            return;
        }
        const mins = Math.floor(remaining / 60);
        const secs = remaining % 60;
        timerEl.textContent = 'Code expires in ' + mins + ':' + (secs < 10 ? '0' : '') + secs;
    }, 1000);
}

// Enter key support
document.getElementById('codeInput').addEventListener('keypress', (e) => {
    if (e.key === 'Enter') verifyCode();
});
</script>

</body>
</html>
