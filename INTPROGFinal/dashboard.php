<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Database connection
$hostname = "localhost";
$username_db = "root";
$password_db = "";
$database = "signupforms";
$conn = new mysqli($hostname, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle feedback submission
if (isset($_POST['submit_feedback'])) {
    $feedback = mysqli_real_escape_string($conn, trim($_POST['feedback']));
    $rating = (int)$_POST['rating']; // Feedback rating
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;
    $insert_feedback = "INSERT INTO feedback (user_id, feedback, rating, anonymous) VALUES ('$user_id', '$feedback', '$rating', '$anonymous')";
    if ($conn->query($insert_feedback) === TRUE) {
        echo "<p>Feedback submitted successfully!</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Retrieve user feedback stats
$feedback_query = "SELECT * FROM feedback WHERE user_id = $user_id";
$feedback_result = $conn->query($feedback_query);
$feedback_count = $feedback_result->num_rows;

// Calculate average rating
$rating_query = "SELECT AVG(rating) as avg_rating FROM feedback WHERE user_id = $user_id";
$avg_rating = $conn->query($rating_query)->fetch_assoc()['avg_rating'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user-dashboard.css">
</head>
<body>

<!-- Wrapper -->
<div class="wrapper">

    <!-- Sidebar Navigation -->
    <nav>
        <ul>
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="feedback_history.php">Feedback History</a></li> <!-- Link to Feedback History -->
            <li><a href="questionnaire.php">Questionnaire</a></li> <!-- Link to the new Questionnaire section -->
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

        <!-- Feedback Statistics -->
        <div class="stats">
            <p>Total Feedback Submitted: <?php echo $feedback_count; ?></p>
            <p>Average Rating: <?php echo number_format($avg_rating, 1); ?> / 5</p>
        </div>

        <!-- Feedback Form -->
        <h3>Submit Your Feedback</h3>
        <form method="POST">
            <textarea name="feedback" required placeholder="Write your feedback here..." rows="4" cols="50"></textarea><br>
            <label>Rate your experience:</label>
            <select name="rating">
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Very Poor</option>
            </select><br>
            <input type="checkbox" name="anonymous"> Submit Anonymously<br>
            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Feedback System. All rights reserved.</p>
</footer>

</body>
</html>
