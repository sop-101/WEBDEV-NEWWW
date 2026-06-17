<?php
include 'db_connect.php';

// COUNT BY CATEGORY
$healthy = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE score BETWEEN 24 AND 30")->fetch_assoc()['total'];

$moderate = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE score BETWEEN 16 AND 23")->fetch_assoc()['total'];

$notHealthy = $conn->query("SELECT COUNT(*) AS total FROM survey_responses WHERE score BETWEEN 10 AND 15")->fetch_assoc()['total'];

// GET ALL RESPONSES
$result = $conn->query("SELECT * FROM survey_responses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Barangay Health Dashboard</title>
    <style>
        body {
            font-family: system-ui, Arial;
            background: #f4f7fb;
            margin: 0;
        }

        .header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .stats {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 20px;
            flex-wrap: wrap;
        }

        .card {
            padding: 20px;
            border-radius: 12px;
            color: white;
            width: 200px;
            text-align: center;
        }

        .healthy { background: #16a34a; }
        .moderate { background: #f59e0b; }
        .bad { background: #dc2626; }

        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #1e3a8a;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        tr:hover {
            background: #f1f5f9;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Barangay Health Dashboard</h1>
</div>

<div style="text-align:center;">
    <a href="survey.php" class="btn">Back to Survey</a>
</div>

<div class="stats">

    <div class="card healthy">
        <h2><?php echo $healthy; ?></h2>
        <p>Healthy Habits</p>
    </div>

    <div class="card moderate">
        <h2><?php echo $moderate; ?></h2>
        <p>Moderate Habits</p>
    </div>

    <div class="card bad">
        <h2><?php echo $notHealthy; ?></h2>
        <p>Needs Evaluation</p>
    </div>

</div>

<table>
    <tr>
        <th>ID</th>
        <th>Score</th>
        <th>Category</th>
        <th>Q1</th>
        <th>Q2</th>
        <th>Q3</th>
        <th>Q4</th>
        <th>Q5</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['score']; ?></td>
        <td><?php echo $row['category']; ?></td>
        <td><?php echo $row['q1']; ?></td>
        <td><?php echo $row['q2']; ?></td>
        <td><?php echo $row['q3']; ?></td>
        <td><?php echo $row['q4']; ?></td>
        <td><?php echo $row['q5']; ?></td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
