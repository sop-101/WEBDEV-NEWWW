<?php
session_start();
include 'db_connect.php';

$submitted = false;
$score = 0;
$category = '';
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;

    $user_id = $_SESSION['user_id'] ?? 0;
    $full_name = trim($_POST['full_name'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $gender = $_POST['gender'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $health_status = $_POST['health_status'] ?? '';
    $checkups = $_POST['checkups'] ?? '';
    $illness_6mo = $_POST['illness_6mo'] ?? '';
    $illness_specify = trim($_POST['illness_specify'] ?? '');

    $conditions_array = $_POST['conditions'] ?? [];
    $conditions = !empty($conditions_array) ? implode(", ", $conditions_array) : 'None';

    $aware_dengue = $_POST['aware_dengue'] ?? 'No';
    $aware_tb = $_POST['aware_tb'] ?? 'No';
    $aware_diabetes = $_POST['aware_diabetes'] ?? 'No';
    $aware_hypertension = $_POST['aware_hypertension'] ?? 'No';

    $info_source = $_POST['info_source'] ?? '';
    $info_source_other = trim($_POST['info_source_other'] ?? '');
    $sufficient_knowledge = $_POST['sufficient_knowledge'] ?? '';
    $interested_seminars = $_POST['interested_seminars'] ?? '';
    $other_programs = trim($_POST['other_programs'] ?? '');

    $scored_questions = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10'];
    foreach ($scored_questions as $q) {
        if (isset($_POST[$q])) {
            $score += (int) $_POST[$q];
        }
    }

    if ($score >= 24 && $score <= 30) {
        $category = 'Healthy Habits';
        $message = 'Great job! You maintain excellent health habits. Keep it up!';
    } elseif ($score >= 16 && $score <= 23) {
        $category = 'Moderate Habits';
        $message = 'You have moderate health habits. There is room for improvement in some areas.';
    } else {
        $category = 'Not Healthy / Needs Evaluation';
        $message = 'Daily factors carry long-term medical risks. It is recommended to check in at the local barangay health station.';
    }

    $stmt = $conn->prepare("INSERT INTO survey_responses 
        (user_id, full_name, age, gender, address, contact, health_status, conditions, checkups, illness_6mo, illness_specify, 
        q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, 
        aware_dengue, aware_tb, aware_diabetes, aware_hypertension, info_source, info_source_other, 
        sufficient_knowledge, interested_seminars, other_programs, total_score, category) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $q1 = (int)($_POST['q1'] ?? 0); $q2 = (int)($_POST['q2'] ?? 0); $q3 = (int)($_POST['q3'] ?? 0);
        $q4 = (int)($_POST['q4'] ?? 0); $q5 = (int)($_POST['q5'] ?? 0); $q6 = (int)($_POST['q6'] ?? 0);
        $q7 = (int)($_POST['q7'] ?? 0); $q8 = (int)($_POST['q8'] ?? 0); $q9 = (int)($_POST['q9'] ?? 0); $q10 = (int)($_POST['q10'] ?? 0);

        // FIXED: Aligned all variables precisely with the binding definitions to stop execution crashes
        $stmt->bind_param("isissssssssiiiiiiiiiisssssssssis", 
            $user_id, $full_name, $age, $gender, $address, $contact, $health_status, $conditions, $checkups, $illness_6mo, $illness_specify,
            $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10,
            $aware_dengue, $aware_tb, $aware_diabetes, $aware_hypertension, $info_source, $info_source_other,
            $sufficient_knowledge, $interested_seminars, $other_programs, $score, $category
        );
        $stmt->execute();
        $stmt->close();
    } else {
        $error = "Database Error: Unable to save response statistics. " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Health Survey</title>
    <link rel="stylesheet" href="survey.css">
</head>
<body>

    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <div class="logo-icon-img">⚕</div>
                <div class="logo-text">
                    <h1>Barangay Health Center</h1>
                    <p>Community Health Survey</p>
                </div>
            </div>
        </div>
    </header>

    <div class="survey-container">
        <div class="survey-form">

            <div class="survey-header">
                <h1>Barangay Health & Lifestyle Survey</h1>
                <p class="disclaimer">
                    This survey is designed to assess the general health status and lifestyle habits of our barangay residents. 
                    All information provided will be kept confidential and used solely for community health planning purposes.
                </p>
            </div>

            <?php if (!empty($error)): ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($submitted && empty($error)): ?>
                <div class="results-section">
                    <h2>Survey Results</h2>
                    <div class="score-display"><?php echo $score; ?> / 30</div>
                    <div class="category-display"><?php echo htmlspecialchars($category); ?></div>
                    <p class="message-display"><?php echo htmlspecialchars($message); ?></p>
                    <div class="button-group" style="margin-top: 20px;">
                        <a href="survey.php" class="btn btn-home">Take Survey Again</a>
                        <a href="index.php" class="btn btn-clear">Back to Home</a>
                    </div>
                </div>
            <?php else: ?>

                <form method="POST" action="survey.php" id="surveyForm">

                    <div class="section">
                        <div class="section-title">Personal Information</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">1.</span> Full Name (Ex: Juan M. Dela Cruz):</div>
                            <input type="text" name="full_name" class="text-input" placeholder="Enter your full name" required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">2.</span> Age:</div>
                            <input type="number" name="age" class="text-input" placeholder="Enter your age" min="1" max="120" required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">3.</span> Gender:</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="gender" value="Male" required> Male</label>
                                <label class="option"><input type="radio" name="gender" value="Female" required> Female</label>
                                <label class="option"><input type="radio" name="gender" value="Rather not say" required> Rather not say</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">4.</span> District / Address:</div>
                            <input type="text" name="address" class="text-input" placeholder="Enter your district or address" required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">5.</span> Contact Number:</div>
                            <input type="tel" name="contact" class="text-input" placeholder="Enter your contact number" required>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">General Health Status</div>

                        <div class="question">
                            <div class="question-text">How would you describe your current health status?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="health_status" value="Excellent" required> Excellent</label>
                                <label class="option"><input type="radio" name="health_status" value="Good" required> Good</label>
                                <label class="option"><input type="radio" name="health_status" value="Fair" required> Fair</label>
                                <label class="option"><input type="radio" name="health_status" value="Poor" required> Poor</label>
                                <label class="option"><input type="radio" name="health_status" value="Very Poor" required> Very Poor</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text">Do you have any of the following pre-existing medical conditions? (Select all that apply)</div>
                            <div class="options">
                                <label class="option"><input type="checkbox" name="conditions[]" value="Hypertension"> Hypertension (High Blood Pressure)</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Diabetes"> Diabetes</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Asthma"> Asthma</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Heart Disease"> Heart Disease</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Tuberculosis"> Tuberculosis</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="None of the above"> None of the above</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text">Do you see a doctor for regular medical check-ups?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="checkups" value="Yes" required> Yes</label>
                                <label class="option"><input type="radio" name="checkups" value="No" required> No</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text">Have you experienced any illness or medical issues in the past 6 months?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="illness_6mo" value="Yes" required onchange="toggleConditional(this, 'illness_specify')"> Yes</label>
                                <label class="option"><input type="radio" name="illness_6mo" value="No" required onchange="toggleConditional(this, 'illness_specify')"> No</label>
                            </div>
                            <div id="illness_specify" class="conditional-field">
                                <div class="question-text">If yes, please specify the illness:</div>
                                <input type="text" name="illness_specify" class="text-input" placeholder="Specify the illness">
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Category 1: Diet & Hydration</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 1:</span> How often do you eat fruits and vegetables?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q1" value="3" required> Daily </label>
                                <label class="option"><input type="radio" name="q1" value="2" required> 3 to 5 times a week </label>
                                <label class="option"><input type="radio" name="q1" value="1" required> 1 to 2 times a week OR Rarely </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 2:</span> How frequently do you consume sugar-sweetened beverages like sodas, sweet milk teas, energy drinks, or instant powdered juices?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q2" value="3" required> Rarely, or less than once a week </label>
                                <label class="option"><input type="radio" name="q2" value="2" required> A few times over the span of a week </label>
                                <label class="option"><input type="radio" name="q2" value="1" required> Every single day </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 3:</span> How many glasses of plain water do you drink throughout the day?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q3" value="3" required> 8 glasses or more </label>
                                <label class="option"><input type="radio" name="q3" value="2" required> 4 to 7 glasses </label>
                                <label class="option"><input type="radio" name="q3" value="1" required> 3 glasses or fewer </label>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Category 2: Daily Lifestyle & Habits</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 4:</span> On average, how many days a week do you do at least 30 minutes of moderate-intensity physical activity?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q4" value="3" required> 5 or more days </label>
                                <label class="option"><input type="radio" name="q4" value="2" required> 1 to 4 days </label>
                                <label class="option"><input type="radio" name="q4" value="1" required> 0 days / None </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 5:</span> How many hours of restful sleep do you manage to get on an average night?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q5" value="3" required> 7 to 9 hours </label>
                                <label class="option"><input type="radio" name="q5" value="2" required> 6 to 10 or more hours </label>
                                <label class="option"><input type="radio" name="q5" value="1" required> Fewer than 6 hours </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 6:</span> Outside of your primary job or school duties, how many hours a day do you spend sitting down looking at screens?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q6" value="3" required> Less than 2 hours </label>
                                <label class="option"><input type="radio" name="q6" value="2" required> 2 to 4 hours </label>
                                <label class="option"><input type="radio" name="q6" value="1" required> More than 4 hours </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 7:</span> Do you currently use any tobacco products, traditional cigarettes, or e-cigarettes/vapes?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q7" value="3" required> No, I have never smoked / I quit completely </label>
                                <label class="option"><input type="radio" name="q7" value="2" required> Sometimes / I smoke occasionally or am trying to cut back </label>
                                <label class="option"><input type="radio" name="q7" value="1" required> Yes, I use tobacco or vape products on a daily basis </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 8:</span> How often do you consume alcoholic beverages?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q8" value="3" required> Never / Rarely </label>
                                <label class="option"><input type="radio" name="q8" value="2" required> Moderately </label>
                                <label class="option"><input type="radio" name="q8" value="1" required> Frequently / Heavily </label>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Category 3: Mental & Preventive Health</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 9:</span> Over the past two weeks, how often have you been bothered by feeling down, depressed, or hopeless?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q9" value="3" required> Not at all / Seldom </label>
                                <label class="option"><input type="radio" name="q9" value="2" required> Several days across the week </label>
                                <label class="option"><input type="radio" name="q9" value="1" required> Nearly every single day </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 10:</span> When was the last time you had standard health metrics checked by a nurse or doctor?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q10" value="3" required> Within the past year </label>
                                <label class="option"><input type="radio" name="q10" value="2" required> 1 to 2 years ago </label>
                                <label class="option"><input type="radio" name="q10" value="1" required> More than 2 years ago / Never </label>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Category 4: Awareness of Common Illness</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 11:</span> Are you aware of the symptoms of the following illnesses?</div>
                            <table class="awareness-table">
                                <thead>
                                    <tr>
                                        <th>Illness</th>
                                        <th class="checkbox-cell">Yes</th>
                                        <th class="checkbox-cell">No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Dengue</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_dengue" value="Yes" required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_dengue" value="No" required></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tuberculosis</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_tb" value="Yes" required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_tb" value="No" required></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diabetes</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_diabetes" value="Yes" required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_diabetes" value="No" required></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hypertension (High Blood Pressure)</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_hypertension" value="Yes" required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_hypertension" value="No" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 12:</span> Where do you usually get your health-related information?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="info_source" value="Barangay Health Center" required> Barangay Health Center</label>
                                <label class="option"><input type="radio" name="info_source" value="Social Media" required> Social Media</label>
                                <label class="option"><input type="radio" name="info_source" value="Television" required> Television</label>
                                <label class="option"><input type="radio" name="info_source" value="Family or Friends" required> Family or Friends</label>
                                <label class="option"><input type="radio" name="info_source" value="School" required> School</label>
                                <label class="option"><input type="radio" name="info_source" value="Others" required onchange="toggleConditional(this, 'info_source_other')"> Others</label>
                            </div>
                            <div id="info_source_other" class="conditional-field">
                                <input type="text" name="info_source_other" class="text-input" placeholder="Please specify">
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 13:</span> In your opinion, do residents have sufficient health-related knowledge?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="Yes" required> Yes</label>
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="No" required> No</label>
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="Not Sure" required> Not Sure</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 14:</span> Are you interested in attending health awareness seminars?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="interested_seminars" value="Yes" required> Yes</label>
                                <label class="option"><input type="radio" name="interested_seminars" value="No" required> No</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 15:</span> What other health programs would you like to have in the Barangay?</div>
                            <textarea name="other_programs" class="textarea-input" placeholder="Please share your suggestions..."></textarea>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-submit">Submit Survey</button>
                        <button type="reset" class="btn btn-clear">Clear Form</button>
                        <a href="index.php" class="btn btn-home">Back to Homepage</a>
                    </div>

                </form>
            <?php endif; ?>

        </div>
    </div>

    <script>
        function toggleConditional(radio, fieldId) {
            const field = document.getElementById(fieldId);
            if (radio.value === 'Yes' || radio.value === 'Others') {
                field.classList.add('active');
            } else {
                field.classList.remove('active');
                const input = field.querySelector('input, textarea');
                if (input) input.value = '';
            }
        }

        document.querySelectorAll('input[name="conditions[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const noneCheckbox = document.querySelector('input[name="conditions[]"][value="None of the above"]');
                const otherCheckboxes = document.querySelectorAll('input[name="conditions[]"]:not([value="None of the above"])');

                if (this.value === 'None of the above') {
                    if (this.checked) {
                        otherCheckboxes.forEach(function(cb) { cb.checked = false; });
                    }
                } else {
                    if (this.checked && noneCheckbox) {
                        noneCheckbox.checked = false;
                    }
                }
            });
        });
    </script>

</body>
</html>
