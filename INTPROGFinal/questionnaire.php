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

// Handle questionnaire submission
if (isset($_POST['submit_questionnaire'])) {
    $question1 = mysqli_real_escape_string($conn, $_POST['question1']);
    $question2 = mysqli_real_escape_string($conn, $_POST['question2']);
    $question3 = mysqli_real_escape_string($conn, $_POST['question3']);
    $question4 = mysqli_real_escape_string($conn, $_POST['question4']);
    $question5 = mysqli_real_escape_string($conn, $_POST['question5']);
    $question6 = mysqli_real_escape_string($conn, $_POST['question6']);
    $question7 = mysqli_real_escape_string($conn, $_POST['question7']);
    $question8 = mysqli_real_escape_string($conn, $_POST['question8']);
    $question9 = mysqli_real_escape_string($conn, $_POST['question9']);
    $question10 = mysqli_real_escape_string($conn, $_POST['question10']);
    $suggestions = mysqli_real_escape_string($conn, $_POST['suggestions']);  // new field for suggestions

    $insert_questionnaire = "INSERT INTO questionnaire_responses (user_id, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, suggestions) 
                             VALUES ('$user_id', '$question1', '$question2', '$question3', '$question4', '$question5', '$question6', '$question7', '$question8', '$question9', '$question10', '$suggestions')";
    if ($conn->query($insert_questionnaire) === TRUE) {
        echo "<p>Thank you for completing the questionnaire!</p>";
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
    <title>Campus Operations Feedback Questionnaire</title>
    <link rel="stylesheet" href="css/user-dashboard.css">
</head>
<body>

<!-- Wrapper -->
<div class="wrapper">

    <!-- Sidebar Navigation -->
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="feedback_history.php">Feedback History</a></li>
            <li><a href="questionnaire.php" class="active">Questionnaire</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="main-content">
        <h2>Campus Operations Feedback Questionnaire</h2>
        <form method="POST">
            <!-- Question 1 -->
            <p>1. How would you rate the overall campus facilities in terms of accessibility and quality?</p>
            <select name="question1" required>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                <option value="Poor">Poor</option>
                <option value="Very Poor">Very Poor</option>
            </select>

            <!-- Question 2 -->
            <p>2. How satisfied are you with the availability of online resources for students (e.g., library, research materials)?</p>
            <select name="question2" required>
                <option value="Very Satisfied">Very Satisfied</option>
                <option value="Satisfied">Satisfied</option>
                <option value="Neutral">Neutral</option>
                <option value="Dissatisfied">Dissatisfied</option>
                <option value="Very Dissatisfied">Very Dissatisfied</option>
            </select>

            <!-- Question 3 -->
            <p>3. How effective do you find the communication between campus administration and students?</p>
            <select name="question3" required>
                <option value="Very Effective">Very Effective</option>
                <option value="Effective">Effective</option>
                <option value="Neutral">Neutral</option>
                <option value="Ineffective">Ineffective</option>
                <option value="Very Ineffective">Very Ineffective</option>
            </select>

            <!-- Question 4 -->
            <p>4. How do you rate the campus security and safety measures in place?</p>
            <select name="question4" required>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                <option value="Poor">Poor</option>
                <option value="Very Poor">Very Poor</option>
            </select>

            <!-- Question 5 -->
            <p>5. How satisfied are you with the campus food and dining services?</p>
            <select name="question5" required>
                <option value="Very Satisfied">Very Satisfied</option>
                <option value="Satisfied">Satisfied</option>
                <option value="Neutral">Neutral</option>
                <option value="Dissatisfied">Dissatisfied</option>
                <option value="Very Dissatisfied">Very Dissatisfied</option>
            </select>

            <!-- Question 6 -->
            <p>6. How easy is it to access your academic grades and other important information online?</p>
            <select name="question6" required>
                <option value="Very Easy">Very Easy</option>
                <option value="Easy">Easy</option>
                <option value="Neutral">Neutral</option>
                <option value="Difficult">Difficult</option>
                <option value="Very Difficult">Very Difficult</option>
            </select>

            <!-- Question 7 -->
            <p>7. How would you rate the campus environment in terms of being inclusive and diverse?</p>
            <select name="question7" required>
                <option value="Very Inclusive">Very Inclusive</option>
                <option value="Inclusive">Inclusive</option>
                <option value="Neutral">Neutral</option>
                <option value="Exclusive">Exclusive</option>
                <option value="Very Exclusive">Very Exclusive</option>
            </select>

            <!-- Question 8 -->
            <p>8. How effective is the campus infrastructure in supporting student activities and events?</p>
            <select name="question8" required>
                <option value="Very Effective">Very Effective</option>
                <option value="Effective">Effective</option>
                <option value="Neutral">Neutral</option>
                <option value="Ineffective">Ineffective</option>
                <option value="Very Ineffective">Very Ineffective</option>
            </select>

            <!-- Question 9 -->
            <p>9. How would you rate the overall cleanliness and maintenance of the campus?</p>
            <select name="question9" required>
                <option value="Excellent">Excellent</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                <option value="Poor">Poor</option>
                <option value="Very Poor">Very Poor</option>
            </select>

            <!-- Question 10 -->
            <p>10. How satisfied are you with the overall campus experience, including academics and extracurricular activities?</p>
            <select name="question10" required>
                <option value="Very Satisfied">Very Satisfied</option>
                <option value="Satisfied">Satisfied</option>
                <option value="Neutral">Neutral</option>
                <option value="Dissatisfied">Dissatisfied</option>
                <option value="Very Dissatisfied">Very Dissatisfied</option>
            </select>

            <!-- Question 11 -->
            <p>11. Do you have any suggestions to improve the campus experience?</p>
            <textarea name="suggestions" rows="4" cols="50" placeholder="Your suggestions here..." required></textarea>

            <button type="submit" name="submit_questionnaire">Submit Questionnaire</button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Feedback System. All rights reserved.</p>
</footer>

</body>
</html>
