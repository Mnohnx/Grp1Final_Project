<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../login.html');
    exit();
}

// Placeholder for account update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data and update admin credentials
}

?>

<h2>Update Admin Credentials</h2>
<form method="POST">
    <label for="username">New Username:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Update</button>
</form>
