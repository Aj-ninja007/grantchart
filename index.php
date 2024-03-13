<?php

$tasks = $_POST['taskName'];
$startDates = $_POST['startDate'];
$endDates = $_POST['endDate'];
$dependencies = $_POST['dependency'];


$chartData = [];

for ($i = 0; $i < count($tasks); $i++) {
    $chartData[] = [
        'task' => $tasks[$i],
        'start' => $startDates[$i],
        'end' => $endDates[$i],
        'dependency' => $dependencies[$i],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gantt Chart</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .gantt-chart {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .task-bar {
            fill: #007BFF;
            stroke: #007BFF;
            stroke-width: 1;
        }

        .dependency-line {
            stroke: #007BFF;
            stroke-width: 2;
        }

        .task-label {
            font-size: 12px;
            text-anchor: middle;
            fill: #333;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Gantt Chart</h2>
    <div class="gantt-chart">
        <svg width="800" height="400">
           
            <?php
            foreach ($chartData as $index => $task) {
                $xStart = strtotime($task['start']) * 1000;
                $xEnd = strtotime($task['end']) * 1000;
                $y = $index * 40 + 20;
            ?>
                <rect class="task-bar" x="<?= $xStart ?>" y="<?= $y ?>" width="<?= $xEnd - $xStart ?>" height="20"></rect>
                <text class="task-label" x="<?= ($xStart + $xEnd) / 2 ?>" y="<?= $y + 15 ?>"><?= $task['task'] ?></text>
                <?php
          
                if (!empty($task['dependency'])) {
                    $dependencyIndex = array_search($task['dependency'], array_column($chartData, 'task'));
                    if ($dependencyIndex !== false) {
                        $dependencyXEnd = strtotime($chartData[$dependencyIndex]['end']) * 1000;
                ?>
                        <line class="dependency-line" x1="<?= $dependencyXEnd ?>" y1="<?= $y + 10 ?>" x2="<?= $xStart ?>" y2="<?= $y + 10 ?>"></line>
                <?php
                    }
                }
                ?>
            <?php
            }
            ?>
        </svg>
    </div>
</body>
</html>
