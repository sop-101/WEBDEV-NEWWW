<?php
// survey.php - Barangay Health Survey Form
// Process form submission
$submitted = false;
$score = 0;
$category = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;

    // Calculate score from scored questions (Q1-Q10)
    $scored_questions = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10'];
    foreach ($scored_questions as $q) {
        if (isset($_POST[$q])) {
            $score += (int) $_POST[$q];
        }
    }

    // Determine category
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

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <div class="logo-icon-img"></div>
                <div class="logo-text">
                    <h1>Barangay Health Center</h1>
                    <p>Community Health Survey</p>
                </div>
            </div>
        </div>
    </header>

    <div class="survey-container">
        <div class="survey-form">

            <!-- Survey Header -->
            <div class="survey-header">
                <h1>Barangay Health & Lifestyle Survey</h1>
                <p class="disclaimer">
                    This survey is designed to assess the general health status and lifestyle habits of our barangay
                    residents.
                    All information provided will be kept confidential and used solely for community health planning
                    purposes.
                </p>
            </div>

            <?php if ($submitted): ?>
                <!-- Results Section -->
                <div class="results-section">
                    <h2>Survey Results</h2>
                    <div class="score-display"><?php echo $score; ?> / 30</div>
                    <div class="category-display"><?php echo $category; ?></div>
                    <p class="message-display"><?php echo $message; ?></p>
                    <div class="button-group" style="margin-top: 20px;">
                        <a href="survey.php" class="btn btn-home">Take Survey Again</a>
                    </div>
                </div>
            <?php else: ?>

                <form method="POST" action="survey.php" id="surveyForm">

                    <!-- ==================== PERSONAL INFORMATION ==================== -->
                    <div class="section">
                        <div class="section-title">Personal Information</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">1.</span> Full Name (Ex: Juan M. Dela
                                Cruz):</div>
                            <input type="text" name="full_name" class="text-input" placeholder="Enter your full name"
                                required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">2.</span> Age:</div>
                            <input type="number" name="age" class="text-input" placeholder="Enter your age" min="1"
                                max="120" required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">3.</span> Gender:</div>
                            <div class="options">
                                <label class="option">
                                    <input type="radio" name="gender" value="Male" required> Male
                                </label>
                                <label class="option">
                                    <input type="radio" name="gender" value="Female" required> Female
                                </label>
                                <label class="option">
                                    <input type="radio" name="gender" value="Rather not say" required> Rather not say
                                </label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">4.</span> District / Address:</div>
                            <input type="text" name="address" class="text-input"
                                placeholder="Enter your district or address" required>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">5.</span> Contact Number:</div>
                            <input type="tel" name="contact" class="text-input" placeholder="Enter your contact number"
                                required>
                        </div>
                    </div>

                    <!-- ==================== GENERAL HEALTH STATUS ==================== -->
                    <div class="section">
                        <div class="section-title">General Health Status</div>

                        <div class="question">
                            <div class="question-text">How would you describe your current health status?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="health_status" value="Excellent" required>
                                    Excellent</label>
                                <label class="option"><input type="radio" name="health_status" value="Good" required>
                                    Good</label>
                                <label class="option"><input type="radio" name="health_status" value="Fair" required>
                                    Fair</label>
                                <label class="option"><input type="radio" name="health_status" value="Poor" required>
                                    Poor</label>
                                <label class="option"><input type="radio" name="health_status" value="Very Poor" required>
                                    Very Poor</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text">Do you have any of the following pre-existing medical conditions?
                                (Select all that apply)</div>
                            <div class="options">
                                <label class="option"><input type="checkbox" name="conditions[]" value="Hypertension">
                                    Hypertension (High Blood Pressure)</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Diabetes">
                                    Diabetes</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Asthma">
                                    Asthma</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Heart Disease">
                                    Heart Disease</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="Tuberculosis">
                                    Tuberculosis</label>
                                <label class="option"><input type="checkbox" name="conditions[]" value="None of the above">
                                    None of the above</label>
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
                            <div class="question-text">Have you experienced any illness or medical issues in the past 6
                                months?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="illness_6mo" value="Yes" required
                                        onchange="toggleConditional(this, 'illness_specify')"> Yes</label>
                                <label class="option"><input type="radio" name="illness_6mo" value="No" required
                                        onchange="toggleConditional(this, 'illness_specify')"> No</label>
                            </div>
                            <div id="illness_specify" class="conditional-field">
                                <div class="question-text">If yes, please specify the illness:</div>
                                <input type="text" name="illness_specify" class="text-input"
                                    placeholder="Specify the illness">
                            </div>
                        </div>
                    </div>

                    <!-- ==================== CATEGORY 1: DIET & HYDRATION ==================== -->
                    <div class="section">
                        <div class="section-title">Category 1: Diet & Hydration</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 1:</span> How often do you eat
                                fruits and vegetables?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q1" value="3" required> Daily (3
                                    Points)</label>
                                <label class="option"><input type="radio" name="q1" value="2" required> 3 to 5 times a week
                                    (2 Points)</label>
                                <label class="option"><input type="radio" name="q1" value="1" required> 1 to 2 times a week
                                    OR Rarely (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Consuming at least 400 grams (roughly 5 servings) of
                                fresh produce daily decreases individual risks for non-communicable chronic illnesses like
                                hypertension and colorectal cancers.
                                <div class="reference">Reference: Devirgiliis, C., Guberti, E., Mistura, L., & Raffo, A.
                                    (2024). Effect of fruit and vegetable consumption on human health: An update of the
                                    literature. <a href="https://www.mdpi.com/2304-8158/13/19/3149" target="_blank">Link</a>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 2:</span> How frequently do
                                you consume sugar-sweetened beverages like sodas, sweet milk teas, energy drinks, or instant
                                powdered juices?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q2" value="3" required> Rarely, or less than
                                    once a week (3 Points)</label>
                                <label class="option"><input type="radio" name="q2" value="2" required> A few times over the
                                    span of a week (2 Points)</label>
                                <label class="option"><input type="radio" name="q2" value="1" required> Every single day (1
                                    Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Frequent intake of free liquid sugars spikes systemic
                                glycemic loads, driving visceral fat accumulation and Type 2 Diabetes development.
                                <div class="reference">Reference: Malik, V. S., Popkin, B. M., Bray, G. A., Despr&eacute;s,
                                    J. P., Willett, W. C., & Hu, F. B. (2010). Sugar-sweetened beverages and risk of
                                    metabolic syndrome and type 2 diabetes: A meta-analysis. <em>Diabetes Care</em>,
                                    <em>33</em>(11), 2477&ndash;2483. <a href="https://doi.org/10.2337/dc10-1079"
                                        target="_blank">Link</a></div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 3:</span> How many glasses of
                                plain water do you drink throughout the day? <em>(Note: 1 glass = approx. 250mL)</em></div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q3" value="3" required> 8 glasses or more (3
                                    Points)</label>
                                <label class="option"><input type="radio" name="q3" value="2" required> 4 to 7 glasses (2
                                    Points)</label>
                                <label class="option"><input type="radio" name="q3" value="1" required> 3 glasses or fewer
                                    (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Proper structural hydration ensures adequate renal
                                clearance, cognitive focus, and safe cardiovascular volume stability.
                                <div class="reference">Reference: National Academies of Sciences, Engineering, and Medicine.
                                    (2005). <em>Dietary reference intakes for water, potassium, sodium, chloride, and
                                        sulfate</em>. The National Academies Press. <a href="https://doi.org/10.17226/10925"
                                        target="_blank">Link</a></div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== CATEGORY 2: DAILY LIFESTYLE & HABITS ==================== -->
                    <div class="section">
                        <div class="section-title">Category 2: Daily Lifestyle & Habits</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 4:</span> On average, how many
                                days a week do you do at least 30 minutes of moderate-intensity physical activity (such as
                                brisk walking, sweeping, or bicycling)?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q4" value="3" required> 5 or more days (3
                                    Points)</label>
                                <label class="option"><input type="radio" name="q4" value="2" required> 1 to 4 days (2
                                    Points)</label>
                                <label class="option"><input type="radio" name="q4" value="1" required> 0 days / None (1
                                    Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> The standard preventative baseline for global
                                cardiovascular health is 150 minutes of moderate physical activity across the week.
                                <div class="reference">Reference: World Health Organization 2020 guidelines on physical
                                    activity and sedentary behaviour. <em>British Journal of Sports Medicine</em>. <a
                                        href="https://pubmed.ncbi.nlm.nih.gov/33239350/" target="_blank">Link</a></div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 5:</span> How many hours of
                                restful sleep do you manage to get on an average night?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q5" value="3" required> 7 to 9 hours (3
                                    Points)</label>
                                <label class="option"><input type="radio" name="q5" value="2" required> 6 to 10 or more
                                    hours (2 Points)</label>
                                <label class="option"><input type="radio" name="q5" value="1" required> Fewer than 6 hours
                                    (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Consistently sleeping less than 6 hours disrupts immune
                                capabilities, cognitive health, and triggers metabolic dysfunction.
                                <div class="reference">Reference: Hirshkowitz, M., et al. (2015). National Sleep
                                    Foundation's sleep time duration recommendations: methodology and results summary.
                                    <em>Sleep Health</em>, <em>1</em>(1), 40&ndash;43. <a
                                        href="https://doi.org/10.1016/j.sleh.2014.12.010" target="_blank">Link</a></div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 6:</span> Outside of your
                                primary job or school duties, how many hours a day do you spend sitting down looking at
                                screens (TV, mobile phone, or computer)?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q6" value="3" required> Less than 2 hours (3
                                    Points)</label>
                                <label class="option"><input type="radio" name="q6" value="2" required> 2 to 4 hours (2
                                    Points)</label>
                                <label class="option"><input type="radio" name="q6" value="1" required> More than 4 hours (1
                                    Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Protracted periods of sitting generate high metabolic
                                stagnation, slowing fat burning regardless of baseline exercise habits.
                                <div class="reference">Reference: Matthews, C. E., et al. (2012). Amount of time spent in
                                    sedentary behaviors and cause-specific mortality in US adults. <em>The American Journal
                                        of Clinical Nutrition</em>, <em>95</em>(2), 437&ndash;445. <a
                                        href="https://doi.org/10.3390/foods13193149" target="_blank">Link</a></div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 7:</span> Do you currently use
                                any tobacco products, traditional cigarettes, or e-cigarettes/vapes?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q7" value="3" required> No, I have never
                                    smoked or used them / I quit completely (3 Points)</label>
                                <label class="option"><input type="radio" name="q7" value="2" required> Sometimes / I smoke
                                    occasionally or am currently trying to cut back (2 Points)</label>
                                <label class="option"><input type="radio" name="q7" value="1" required> Yes, I use tobacco
                                    or vape products on a daily basis (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Daily nicotine and tobacco usage introduces carcinogens
                                and damages vascular tissue, drastically escalating chronic respiratory disease risks.
                                <div class="reference">Reference: WHO Framework Convention on Tobacco Control, World Health
                                    Organization Institutional Repository for Information Sharing (IRIS) 2003. <a
                                        href="https://iris.who.int/items/81d339dd-1df0-4b85-8cf1-7b862c40036a"
                                        target="_blank">Link</a></div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 8:</span> How often do you
                                consume alcoholic beverages?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q8" value="3" required> Never / Rarely (Less
                                    than once a month) (3 Points)</label>
                                <label class="option"><input type="radio" name="q8" value="2" required> Moderately (1 to 2
                                    standard drinks a week) (2 Points)</label>
                                <label class="option"><input type="radio" name="q8" value="1" required> Frequently / Heavily
                                    (Multiple times a week or regular heavy drinking sessions) (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Excessive alcohol consumption increases hepatic stress,
                                causes regular blood pressure spikes, and elevates long-term neurological risks.
                                <div class="reference">Reference: Centers for Disease Control and Prevention. (2022).
                                    <em>Dietary guidelines for alcohol</em>. U.S. Department of Health and Human Services.
                                    <a href="https://www.cdc.gov/alcohol/fact-sheets/dietary-guidelines.html"
                                        target="_blank">Link</a></div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== CATEGORY 3: MENTAL & PREVENTIVE HEALTH ==================== -->
                    <div class="section">
                        <div class="section-title">Category 3: Mental & Preventive Health</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 9:</span> Over the past two
                                weeks, how often have you been bothered by feeling down, depressed, or hopeless, or having
                                little interest or pleasure in doing things?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q9" value="3" required> Not at all / Seldom
                                    (3 Points)</label>
                                <label class="option"><input type="radio" name="q9" value="2" required> Several days across
                                    the week (2 Points)</label>
                                <label class="option"><input type="radio" name="q9" value="1" required> Nearly every single
                                    day (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> This follows the validated clinical PHQ-2 protocol used
                                by general practitioners to catch primary mental health stressors.
                                <div class="reference">Reference: Gelaye, B., et al. (2016). Diagnostic validity of the
                                    Patient Health Questionnaire-2 (PHQ-2) among Ethiopian adults. <em>Comprehensive
                                        Psychiatry</em>, <em>70</em>, 216&ndash;221. <a
                                        href="https://doi.org/10.1016/j.comppsych.2016.07.011" target="_blank">Link</a>
                                </div>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 10:</span> When was the last
                                time you had standard health metrics (such as your blood pressure, weight, or blood sugar)
                                checked by a nurse or doctor?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="q10" value="3" required> Within the past
                                    year (3 Points)</label>
                                <label class="option"><input type="radio" name="q10" value="2" required> 1 to 2 years ago (2
                                    Points)</label>
                                <label class="option"><input type="radio" name="q10" value="1" required> More than 2 years
                                    ago / Never (1 Point)</label>
                            </div>
                            <div class="medical-rationale">
                                <strong>Medical Rationale:</strong> Early community-level biometric diagnostic monitoring
                                flags asymptomatic conditions like hypertension before vascular complications appear.
                                <div class="reference">Reference: World Health Organization. (2020). <em>Package of
                                        essential noncommunicable (PEN) disease interventions for primary health care</em>.
                                    <a href="https://iris.who.int/handle/10665/342274" target="_blank">Link</a></div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== CATEGORY 4: AWARENESS OF COMMON ILLNESS ==================== -->
                    <div class="section">
                        <div class="section-title">Category 4: Awareness of Common Illness</div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 11:</span> Are you aware of
                                the symptoms of the following illnesses?</div>
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
                                        <td class="checkbox-cell"><input type="radio" name="aware_dengue" value="Yes"
                                                required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_dengue" value="No"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tuberculosis</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_tb" value="Yes" required>
                                        </td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_tb" value="No" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diabetes</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_diabetes" value="Yes"
                                                required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_diabetes" value="No"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hypertension (High Blood Pressure)</strong></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_hypertension" value="Yes"
                                                required></td>
                                        <td class="checkbox-cell"><input type="radio" name="aware_hypertension" value="No"
                                                required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 12:</span> Where do you
                                usually get your health-related information?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="info_source" value="Barangay Health Center"
                                        required> Barangay Health Center</label>
                                <label class="option"><input type="radio" name="info_source" value="Social Media" required>
                                    Social Media</label>
                                <label class="option"><input type="radio" name="info_source" value="Television" required>
                                    Television</label>
                                <label class="option"><input type="radio" name="info_source" value="Family or Friends"
                                        required> Family or Friends</label>
                                <label class="option"><input type="radio" name="info_source" value="School" required>
                                    School</label>
                                <label class="option"><input type="radio" name="info_source" value="Others" required
                                        onchange="toggleConditional(this, 'info_source_other')"> Others</label>
                            </div>
                            <div id="info_source_other" class="conditional-field">
                                <input type="text" name="info_source_other" class="text-input" placeholder="Please specify">
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 13:</span> In your opinion, do
                                residents have sufficient health-related knowledge?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="Yes" required>
                                    Yes</label>
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="No" required>
                                    No</label>
                                <label class="option"><input type="radio" name="sufficient_knowledge" value="Not Sure"
                                        required> Not Sure</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 14:</span> Are you interested
                                in attending health awareness seminars?</div>
                            <div class="options">
                                <label class="option"><input type="radio" name="interested_seminars" value="Yes" required>
                                    Yes</label>
                                <label class="option"><input type="radio" name="interested_seminars" value="No" required>
                                    No</label>
                            </div>
                        </div>

                        <div class="question">
                            <div class="question-text"><span class="question-number">Question 15:</span> What other health
                                programs would you like to have in the Barangay?</div>
                            <textarea name="other_programs" class="textarea-input"
                                placeholder="Please share your suggestions..."></textarea>
                        </div>
                    </div>

                    <!-- Button Group -->
                    <div class="button-group">
                        <button type="submit" class="btn btn-submit">Submit Survey</button>
                        <button type="reset" class="btn btn-clear">Clear Form</button>
                        <a href="index.php" class="btn btn-home">Home</a>
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

        document.querySelectorAll('input[name="conditions[]"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const noneCheckbox = document.querySelector('input[name="conditions[]"][value="None of the above"]');
                const otherCheckboxes = document.querySelectorAll('input[name="conditions[]"]:not([value="None of the above"])');

                if (this.value === 'None of the above') {
                    if (this.checked) {
                        otherCheckboxes.forEach(function (cb) { cb.checked = false; });
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
