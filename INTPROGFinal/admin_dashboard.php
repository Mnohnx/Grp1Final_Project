<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.html');
    exit();
}

// Database connection
$hostname = "localhost";
$username_db = "root";
$password_db = "";
$database = "signupforms";
$conn = new mysqli($hostname, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve feedback ratings count
$ratings_count_query = "SELECT rating, COUNT(*) AS count FROM feedback GROUP BY rating ORDER BY rating";
$ratings_result = $conn->query($ratings_count_query);

// Prepare the data for the pie chart
$ratings_data = [0, 0, 0, 0, 0]; // assuming you have ratings from 1 to 5
$total_feedbacks = 0;

if ($ratings_result->num_rows > 0) {
    while ($row = $ratings_result->fetch_assoc()) {
        $ratings_data[$row['rating'] - 1] = $row['count'];
        $total_feedbacks += $row['count'];
    }
}

// Retrieve the number of distinct users who have submitted feedback
$users_count_query = "SELECT COUNT(DISTINCT user_id) AS user_count FROM feedback";
$users_result = $conn->query($users_count_query);
$users_count = 0;

if ($users_result->num_rows > 0) {
    $row = $users_result->fetch_assoc();
    $users_count = $row['user_count'];
}

// Retrieve feedback submission over time for the line chart (e.g., weekly or monthly)
// Assuming the column that tracks submission date is named 'created_at' (adjust if necessary)
$feedback_over_time_query = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS date, COUNT(*) AS count FROM feedback GROUP BY date ORDER BY date";

$feedback_over_time_result = $conn->query($feedback_over_time_query);

$feedback_dates = [];
$feedback_counts = [];

if ($feedback_over_time_result->num_rows > 0) {
    while ($row = $feedback_over_time_result->fetch_assoc()) {
        $feedback_dates[] = $row['date'];
        $feedback_counts[] = $row['count'];
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin-dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .chart-item {
            flex: 1;
            min-width: 350px;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .chart-item h3 {
            text-align: center;
            margin-bottom: 15px;
        }

        canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>

<!-- Sidebar Navigation -->
<nav>
    <ul>
        <li><a href="admin_dashboard.php" class="active">Admin Dashboard</a></li>
        <li><a href="admin_view_feedback.php">View Feedbacks</a></li>
        <li><a href="admin_settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Main Content -->
<div class="container">
    <h2>Welcome, Admin!</h2>
    <p>Click <a href="admin_view_feedback.php">View Feedbacks</a> to view all the feedback submitted by users.</p>

    <!-- Chart Container -->
    <div class="chart-container">
        <!-- Pie Chart -->
        <div class="chart-item">
            <h3>Feedback Ratings Distribution</h3>
            <canvas id="feedbackChart" width="400" height="400"></canvas>
        </div>

        <!-- Bar Chart: User Count -->
        <div class="chart-item">
            <h3>User Count</h3>
            <canvas id="userChart" width="400" height="400"></canvas>
        </div>

        <!-- Line Chart: Feedback Over Time -->
        <div class="chart-item">
            <h3>Feedback Submission Over Time</h3>
            <canvas id="timeChart" width="400" height="400"></canvas>
        </div>
    </div>

    <script>
        // Pie chart data from PHP
        var ratingsData = <?php echo json_encode($ratings_data); ?>;
        var totalFeedbacks = <?php echo $total_feedbacks; ?>;

        var ctx = document.getElementById('feedbackChart').getContext('2d');
        var feedbackChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['1 - Very Poor', '2 - Poor', '3 - Average', '4 - Good', '5 - Excellent'],
                datasets: [{
                    label: 'Feedback Ratings',
                    data: ratingsData,
                    backgroundColor: ['#FF5733', '#FF8D1A', '#FFC300', '#DAF7A6', '#28B463'],
                    borderColor: ['#FF5733', '#FF8D1A', '#FFC300', '#DAF7A6', '#28B463'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var percentage = ((tooltipItem.raw / totalFeedbacks) * 100).toFixed(2) + '%';
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' feedbacks (' + percentage + ')';
                            }
                        }
                    }
                }
            }
        });

        // Bar chart data for users count
        var usersCount = <?php echo $users_count; ?>;

        var ctx2 = document.getElementById('userChart').getContext('2d');
        var userChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Users'],
                datasets: [{
                    label: 'Number of Users',
                    data: [usersCount],
                    backgroundColor: '#4CAF50',
                    borderColor: '#388E3C',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Total Users: ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'User Count'
                        }
                    }
                }
            }
        });

        // Line chart data for feedback over time
        var feedbackDates = <?php echo json_encode($feedback_dates); ?>;
        var feedbackCounts = <?php echo json_encode($feedback_counts); ?>;

        var ctx3 = document.getElementById('timeChart').getContext('2d');
        var timeChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: feedbackDates,
                datasets: [{
                    label: 'Feedback Submissions',
                    data: feedbackCounts,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Submissions: ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Submissions'
                        }
                    }
                }
            }
        });
    </script>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Feedback System. All rights reserved.</p>
</footer>

</body>
</html>
