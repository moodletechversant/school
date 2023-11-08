<?php
require_once(__DIR__ . '/../../config.php');
$current_userid = $USER->id;

$assignData = $DB->get_record_sql("SELECT * FROM {student_assign} WHERE user_id=$current_userid");
// print_r($assignData);exit();
$division = $assignData->s_division;
// print_r($division);exit();
$sql = $DB->get_records_sql("SELECT sa.*, s.s_gender 
FROM {student_assign} sa
INNER JOIN {student} s ON sa.user_id = s.user_id
WHERE sa.s_division = '$division'");

$totalBoys = 0;
$totalGirls = 0;

foreach ($sql as $record) {
    // print_r($record);exit();

    if ($record->s_gender == 'male') {
        $totalBoys++;
    } elseif ($record->s_gender == 'female') {
        $totalGirls++;
    }
}

$totalBoysJson = json_encode([$totalBoys]);
$totalGirlsJson = json_encode([$totalGirls]);

echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '  <title>Number of students (Pie Chart)</title>';
echo '  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
echo '  <style>';
echo '    body {';
echo '      display: flex;';
echo '      justify-content: center;';
echo '      align-items: center;';
echo '      height: 100vh;';
echo '    }';
echo '    .card {';
echo '      max-width: 400px;';
echo '      border: 1px solid #ccc;';
echo '      border-radius: 4px;';
echo '      padding: 20px;';
echo '      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);';
echo '      text-align: center;';
echo '    }';
echo '    #attendanceChart {';
echo '      max-height: 300px;';
echo '      margin: 0 auto;';
echo '    }';
echo '  </style>';
echo '</head>';
echo '<body>';
echo '  <div class="card">';
echo '    <h2>Number of students</h2>';
echo '    <canvas id="attendanceChart"></canvas>';
echo '<h4>Total: ' . ($totalBoys + $totalGirls) . ' students</h4>';

echo '  </div>';
echo '  <script>';
echo '    document.addEventListener("DOMContentLoaded", function() {';
echo '      var attendanceData = {';
echo '        datasets: [';
echo '          {';
echo '            data: [' . $totalBoys . ', ' . $totalGirls . '],';
echo '            backgroundColor: ["#3e95cd", "#8e5ea2"],';
echo '          },';
echo '        ],';
echo '        labels: ["Boys", "Girls"],';
echo '      };';
echo '      var chartConfig = {';
echo '        type: "doughnut",';
echo '        data: attendanceData,';
echo '        options: {';
echo '          responsive: true,';
echo '          title: {';
echo '            display: true,';
echo '            text: "Student Attendance Distribution",';
echo '          },';
echo '          legend: {';
echo '            position: "bottom",';
echo '            labels: {';
echo '              fontColor: "#333",';
echo '            },';
echo '          },';
echo '          tooltips: {';
echo '            callbacks: {';
echo '              label: function(tooltipItem, data) {';
echo '                var dataset = data.datasets[tooltipItem.datasetIndex];';
echo '                var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {';
echo '                  return previousValue + currentValue;';
echo '                });';
echo '                var currentValue = dataset.data[tooltipItem.index];';
echo '                var percentage = Math.floor(((currentValue / total) * 100) + 0.5);';
echo '                return data.labels[tooltipItem.index] + ": " + currentValue + " (" + percentage + "%)";';
echo '              },';
echo '            },';
echo '          },';
echo '        },';
echo '      };';
echo '      var ctx = document.getElementById("attendanceChart").getContext("2d");';
echo '      new Chart(ctx, chartConfig);';
echo '    });';
echo '  </script>';
echo '</body>';
echo '</html>';
?>
