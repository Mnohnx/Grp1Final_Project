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

// Retrieve user feedback
$feedback_query = "SELECT * FROM feedback WHERE user_id = $user_id";
$feedback_result = $conn->query($feedback_query);

// Handle feedback deletion
if (isset($_POST['delete_feedback'])) {
    $feedback_id = (int)$_POST['feedback_id'];
    $delete_feedback_query = "DELETE FROM feedback WHERE id = $feedback_id AND user_id = $user_id";
    if ($conn->query($delete_feedback_query) === TRUE) {
        echo "<p>Feedback deleted successfully!</p>";
        header("Location: feedback_history.php"); // Redirect to refresh the page
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback History</title>
    <link rel="stylesheet" href="css/user-dashboard.css">
</head>
<body>

<!-- Wrapper -->
<div class="wrapper">

    <!-- Sidebar Navigation -->
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="feedback_history.php" class="active">Feedback History</a></li>
            <li><a href="questionnaire.php">Questionnaire</a></li> <!-- Link to the new Questionnaire section -->
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h2>Your Feedback History</h2>
        <div class="feedback-list">
            <?php
            if ($feedback_result->num_rows > 0) {
                while($feedback = $feedback_result->fetch_assoc()) {
                    echo "<div class='feedback-item'>";
                    if ($feedback['anonymous']) {
                        echo "<p><strong>Anonymous</strong></p>";
                    } else {
                        echo "<p><strong>$username</strong></p>";
                    }
                    echo "<p>Rating: " . $feedback['rating'] . "/5</p>";
                    echo "<p>" . htmlspecialchars($feedback['feedback']) . "</p>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='feedback_id' value='" . $feedback['id'] . "'>";
                    echo "<button type='submit' name='delete_feedback'>Delete</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No feedback submitted yet.</p>";
            }
            ?>
        </div>
    </div>

</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Feedback System. All rights reserved.</p>
</footer>

</body>
</html>
