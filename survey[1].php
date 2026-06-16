<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db_connect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_user.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$alreadySubmitted = false;

$check = $conn->prepare("SELECT id FROM survey_responses WHERE user_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $alreadySubmitted = true;
}
?>

<!DOCTYPE html>
<html lang="tl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pangkalahatang Pagsusuri sa Kalusugan - BRGY 727</title>
    <link rel="stylesheet" href="survey.css">
</head>

<body>

<header class="header">
    <div class="header-left">
        <div class="logo-section">
            <img src="images/HEALTH.PNG" class="logo-icon-img" alt="Health">
            <div class="logo-text">
                <h1>BRGY 727</h1>
                <p>HEALTH CAMPAIGN</p>
            </div>
        </div>
    </div>
</header>

<main class="survey-container">

<?php if ($alreadySubmitted): ?>
    <div style="background:#f8d7da;padding:15px;border-radius:8px;margin-bottom:20px;">
        You already submitted this survey.
    </div>
<?php endif; ?>

<form action="submit_survey.php" method="POST" class="survey-form">

<div class="survey-header">
    <h1>PANGKAHALATANG PAGSUSURI SA KALUSUGAN</h1>
    <p class="disclaimer">
        PAALALA: This survey is for educational purposes only.
    </p>
</div>

<!-- SECTION 1 -->
<div class="section">
    <div class="section-title">I. DIET AND HYDRATION</div>

    <div class="question">
        <p>1. Fruits & vegetables?</p>
        <label><input type="radio" name="q1" value="5_or_more" required> 5 or more</label>
        <label><input type="radio" name="q1" value="1_to_4"> 1 to 4</label>
        <label><input type="radio" name="q1" value="none"> None</label>
    </div>

    <div class="question">
        <p>2. Sugary drinks?</p>
        <label><input type="radio" name="q2" value="rarely" required> Rarely</label>
        <label><input type="radio" name="q2" value="few_times"> Few times</label>
        <label><input type="radio" name="q2" value="daily"> Daily</label>
    </div>

    <div class="question">
        <p>3. Water intake?</p>
        <label><input type="radio" name="q3" value="8_or_more" required> 8+</label>
        <label><input type="radio" name="q3" value="4_to_7"> 4–7</label>
        <label><input type="radio" name="q3" value="low"> Low</label>
    </div>
</div>

<!-- SECTION 2 -->
<div class="section">
    <div class="section-title">II. LIFESTYLE</div>

    <div class="question">
        <p>4. Exercise?</p>
        <label><input type="radio" name="q4" value="5_days" required> 5 days</label>
        <label><input type="radio" name="q4" value="1_to_4"> 1–4</label>
        <label><input type="radio" name="q4" value="none"> None</label>
    </div>

    <div class="question">
        <p>5. Sleep?</p>
        <label><input type="radio" name="q5" value="7_to_9" required> 7–9 hrs</label>
        <label><input type="radio" name="q5" value="less"> Less</label>
    </div>

    <div class="question">
        <p>6. Screen time?</p>
        <label><input type="radio" name="q6" value="low" required> Low</label>
        <label><input type="radio" name="q6" value="medium"> Medium</label>
        <label><input type="radio" name="q6" value="high"> High</label>
    </div>

    <div class="question">
        <p>7. Smoking?</p>
        <label><input type="radio" name="q7" value="never" required> Never</label>
        <label><input type="radio" name="q7" value="sometimes"> Sometimes</label>
        <label><input type="radio" name="q7" value="daily"> Daily</label>
    </div>

    <div class="question">
        <p>8. Alcohol?</p>
        <label><input type="radio" name="q8" value="never" required> Never</label>
        <label><input type="radio" name="q8" value="moderate"> Moderate</label>
        <label><input type="radio" name="q8" value="heavy"> Heavy</label>
    </div>
</div>

<!-- SECTION 3 -->
<div class="section">
    <div class="section-title">III. MENTAL HEALTH</div>

    <div class="question">
        <p>9. Depression feelings?</p>
        <label><input type="radio" name="q9" value="none" required> None</label>
        <label><input type="radio" name="q9" value="some"> Some</label>
        <label><input type="radio" name="q9" value="frequent"> Frequent</label>
    </div>

    <div class="question">
        <p>10. Last checkup?</p>
        <label><input type="radio" name="q10" value="1_year" required> 1 year</label>
        <label><input type="radio" name="q10" value="2_years"> 2 years</label>
        <label><input type="radio" name="q10" value="never"> Never</label>
    </div>
</div>

<div class="button-group">
    <button type="submit" class="btn btn-submit" <?php if($alreadySubmitted) echo 'disabled'; ?>>
        Submit Survey
    </button>

    <a href="homepage.php" class="btn btn-home">Home</a>
</div>

</form>
</main>

</body>
</html>
