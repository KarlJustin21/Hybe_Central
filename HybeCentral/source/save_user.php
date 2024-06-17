<?php
require_once 'config.php';

$response = array('success' => false, 'message' => 'Account creation failed.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['userN'];
    $password = $_POST['passw']; // No password hashing
    $verification_code = $_POST['verification_code'];

    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response['message'] = "Email already exists.";
        echo json_encode($response);
        exit();
    }

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response['message'] = "Username already exists.";
        echo json_encode($response);
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (email, username, password, verification_code) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $username, $password, $verification_code);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Account created successfully.";
    } else {
        $response['message'] = "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
