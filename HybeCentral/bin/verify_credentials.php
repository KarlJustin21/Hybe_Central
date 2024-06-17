<?php
// Include the database connection file
include("config.php");

// Check if the form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username, password, and verification code from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $verificationCode = $_POST["verification_code"];

    // Function to verify credentials
    function verifyCredentials($username, $password, $conn) {
        // Prepare a SQL statement to check if the username and password match a record in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row with the given username
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Return user data if credentials are valid
                return $row;
            }
        }
        // Return false if credentials are invalid
        return false;
    }

    // Function to verify verification code
    function verifyVerificationCode($username, $verificationCode, $conn) {
        // Prepare a SQL statement to check if the verification code matches the one stored in the database for the given username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND verification_code = ?");
        $stmt->bind_param("ss", $username, $verificationCode);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row with matching username and verification code
        if ($result->num_rows == 1) {
            // Return true if the verification code is valid
            return true;
        } else {
            // Return false if the verification code is invalid
            return false;
        }
    }

    // Verify credentials
    $userData = verifyCredentials($username, $password, $conn);

    if ($userData) {
        // If credentials are valid, verify the verification code
        $verificationResult = verifyVerificationCode($username, $verificationCode, $conn);
        if ($verificationResult) {
            // Verification successful, return success response
            echo json_encode(array("success" => true));
        } else {
            // Verification failed, return error response
            echo json_encode(array("success" => false, "message" => "Invalid verification code"));
        }
    } else {
        // If credentials are invalid, return error response
        echo json_encode(array("success" => false, "message" => "Invalid username or password"));
    }
}
?>
