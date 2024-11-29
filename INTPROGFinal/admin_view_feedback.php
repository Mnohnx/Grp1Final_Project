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

// Retrieve all feedback
$feedback_query = "SELECT f.feedback, f.rating, u.username, f.anonymous, f.created_at 
                   FROM feedback f 
                   JOIN users u ON f.user_id = u.id 
                   ORDER BY f.created_at DESC";
$feedback_result = $conn->query($feedback_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin-dashboard.css">
</head>
<body>

<!-- Sidebar Navigation -->
<nav>
    <ul>
        <li><a href="admin_dashboard.php">Admin Dashboard</a></li>    
        <li><a href="admin_view_feedback.php" class="active">View Feedbacks</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Main Content -->
<div class="container">
    <h2>Welcome, Admin!</h2>
    <h3>All Feedback:</h3>

    <?php
    if ($feedback_result->num_rows > 0) {
        while($feedback = $feedback_result->fetch_assoc()) {
            echo "<div class='feedback-item'>";
            
            // Display anonymous or username based on the feedback's anonymity setting
            echo "<strong>" . ($feedback['anonymous'] ? "Anonymous" : htmlspecialchars($feedback['username'])) . ":</strong>";
            
            // Display feedback content
            echo "<p>" . htmlspecialchars($feedback['feedback']) . "</p>";
            
            // Display rating
            echo "<p><strong>Rating:</strong> " . $feedback['rating'] . "/5</p>";
            
            // Display submission date
            echo "<p><em>Submitted on: " . date("F j, Y, g:i a", strtotime($feedback['created_at'])) . "</em></p>";
            
            echo "</div>";
        }
    } else {
        echo "<p>No feedback received yet.</p>";
    }
    ?>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Feedback System. All rights reserved.</p>
</footer>

        
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
