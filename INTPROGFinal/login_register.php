<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$database = "signupforms";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input function to prevent SQL injection
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Handling registration
if (isset($_POST['register'])) {
    $username = sanitize_input($_POST['reg_username']);
    $password = sanitize_input($_POST['reg_password']);
    
    // Hash password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($check_query);
    
    if ($result->num_rows > 0) {
        // User already exists
        echo "Username already taken!";
    } else {
        // Insert new user
        $insert_query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($insert_query) === TRUE) {
            // Successful registration message with modal
            echo "
                <!-- Modal -->
                <div id='successModal' style='display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 1000;'>
                    <div style='
                        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                        background: #fff; padding: 30px; border-radius: 10px; width: 80%; max-width: 400px;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); text-align: center; font-family: Arial, sans-serif;'>
                        <h2 style='color: #28a745; font-size: 24px;'>Registration Successful!</h2>
                        <p style='font-size: 18px; color: #555;'>You will be redirected to the login page in 3 seconds...</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        // Redirect to login page after 3 seconds
                        window.location.href = 'login.html';
                    }, 3000);
                </script>
            ";
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}


if (isset($_POST['login'])) {
    $username = sanitize_input($_POST['login_username']);
    $password = sanitize_input($_POST['login_password']);
    
    // Special case: check if username and password are for admin
    if ($username === 'admin' && $password === 'admin123') {
        session_start();
        $_SESSION['username'] = 'admin';
        $_SESSION['user_id'] = 1; // assuming admin has a user ID of 1
        
        // Set a cookie for auto login (optional)
        setcookie("user", 'admin', time() + (86400 * 30), "/"); // 30 days
        
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    }
    
    // Query to check if the user exists
    $login_query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($login_query);
    
    if ($result->num_rows > 0) {
        // User exists, now check password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session or cookies
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            
            // Set a cookie for auto login (optional)
            setcookie("user", $username, time() + (86400 * 30), "/"); // 30 days
            
            header("Location: dashboard.php"); // Redirect to regular dashboard
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
}

$conn->close();

?>