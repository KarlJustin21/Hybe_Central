<?php
session_start();

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

// Update user profile based on form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];

    if (isset($_POST['displayName']) || isset($_POST['birthdate']) || isset($_POST['bio'])) {
        $displayName = $_POST['displayName'];
        $birthdate = $_POST['birthdate'];
        $bio = $_POST['bio'];

        $stmt = mysqli_prepare($conn, "UPDATE users SET displayName=?, birthdate=?, bio=? WHERE username=?");
        mysqli_stmt_bind_param($stmt, "ssss", $displayName, $birthdate, $bio, $username);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error updating profile: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }

    if (isset($_POST['top1']) || isset($_POST['top2']) || isset($_POST['top3'])) {
        $top1 = $_POST['top1'];
        $top2 = $_POST['top2'];
        $top3 = $_POST['top3'];

        $stmt = mysqli_prepare($conn, "UPDATE users SET top1=?, top2=?, top3=? WHERE username=?");
        mysqli_stmt_bind_param($stmt, "ssss", $top1, $top2, $top3, $username);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error updating top picks: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
