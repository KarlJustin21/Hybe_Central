<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
    $code = $_POST['code'];

    // Database connection settings
    $host = '127.0.0.1';
    $db = 'hybe_central';
    $user = 'root';
    $pass = '';

    // Create connection
    $conn = mysqli_connect($host, $user, $pass, $db);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and bind
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if user exists
    if ($user = mysqli_fetch_assoc($result)) {
        // Verify the password
        if ($username ==  $user['username']  && $password  == $user['password'] && $code === $user['verification_code']) {
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Redirect to the user dashboard
            header('Location: user_dashboard.html');
            exit;
        } else {
            echo "Invalid password or verification code.";
        }
    } else {
        echo "No user found with that username.";
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Redirect to login form if the request method is not POST
    header('Location: login.html');
    exit;
}
?>
