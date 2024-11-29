<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="css/admin-dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .settings-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .settings-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .settings-header h2 {
            color: #4CAF50;
        }

        .settings-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }

        .settings-item {
            flex: 1 1 calc(30% - 10px);
            min-width: 250px;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .settings-item:hover {
            background-color: #e8f5e9;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .settings-item a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .settings-item a:hover {
            text-decoration: underline;
        }

        
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
            <li><a href="admin_view_feedback.php">View Feedbacks</a></li>
            <li><a href="admin_settings.php" class="active">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Settings Content -->
    <div class="settings-container">
        <div class="settings-header">
            <h2>Admin Settings</h2>
        </div>
        
        <div class="settings-grid">
            <div class="settings-item">
                <a href="admin-settings/update_account.php">Update Admin Credentials</a>
            </div>
            <div class="settings-item">
                <a href="admin-settings/manage_feedback_categories.php">Manage Feedback Categories</a>
            </div>
            <div class="settings-item">
                <a href="admin-settings/toggle_anonymous_feedback.php">Toggle Anonymous Feedback</a>
            </div>
            <div class="settings-item">
                <a href="admin-settings/manage_users.php">Manage User Roles</a>
            </div>
            <div class="settings-item">
                <a href="admin-settings/database_backup.php">Database Backup</a>
            </div>
            <div class="settings-item">
                <a href="admin-settings/dark_mode_toggle.php">Toggle Dark Mode</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Feedback System. All rights reserved.</p>
    </footer>
</body>
</html>
