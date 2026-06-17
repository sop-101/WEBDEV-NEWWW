<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["adminLoggedIn"]) || $_SESSION["adminLoggedIn"] !== true) {
    header("Location: login.php");
    exit();
}

$healthy = 0;
$moderate = 0;
$notHealthy = 0;

$healthy_query = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE total_score BETWEEN 24 AND 30");
if ($healthy_query) {
    $healthy = $healthy_query->fetch_assoc()['total'];
}

$moderate_query = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE total_score BETWEEN 16 AND 23");
if ($moderate_query) {
    $moderate = $moderate_query->fetch_assoc()['total'];
}

$notHealthy_query = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE total_score BETWEEN 10 AND 15");
if ($notHealthy_query) {
    $notHealthy = $notHealthy_query->fetch_assoc()['total'];
}

$result = $conn->query("SELECT * FROM survey_responses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Health Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <header class="header">
        <h1>BRGY 727 Health Administration Panel</h1>
        <div class="header-actions">
            <a href="index.php" class="btn home-btn">Homepage</a>
            <a href="survey.php" class="btn home-btn">View Survey</a>
        </div>
    </header>

    <main class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo $healthy; ?></div>
            <div class="stat-label">Healthy Habits (24 - 30)</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $moderate; ?></div>
            <div class="stat-label">Moderate Habits (16 - 23)</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $notHealthy; ?></div>
            <div class="stat-label">Needs Evaluation (10 - 15)</div>
        </div>
    </main>

    <section class="table-section">
        <div class="section-header">
            <div class="section-title">Submitted Resident Health Profiles</div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Calculated Score</th>
                        <th>Health Evaluation Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><strong>#<?php echo $row['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($row['full_name'] ?? 'Anonymous'); ?></td>
                                <td><?php echo htmlspecialchars($row['age'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['gender'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['contact'] ?? 'N/A'); ?></td>
                                <td>
                                    <strong><?php echo $row['total_score']; ?> / 30</strong>
                                    <div class="risk-bar-container">
                                        <?php 
                                            $score = $row['total_score'];
                                            $bar_class = 'risk-bar-low';
                                            if ($score >= 24) { $bar_class = 'risk-bar-low'; }
                                            elseif ($score >= 16) { $bar_class = 'risk-bar-medium'; }
                                            else { $bar_class = 'risk-bar-high'; }
                                        ?>
                                        <div class="risk-bar <?php echo $bar_class; ?>" style="width: <?php echo ($score / 30) * 100; ?>%;"></div>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $cat = $row['category'] ?? 'Needs Evaluation';
                                        $badge_class = 'risk-high';
                                        if (strpos(strtolower($cat), 'healthy habits') !== false) { $badge_class = 'risk-low'; }
                                        elseif (strpos(strtolower($cat), 'moderate') !== false) { $badge_class = 'risk-medium'; }
                                    ?>
                                    <span class="risk-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($cat); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <div class="empty-state-text">No health records submitted yet in this barangay group container.</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer class="footer">
        © 2026 Barangay 727 Internal Health Registry Monitoring Environment.
    </footer>

</body>
</html>
