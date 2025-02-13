<?php

/***
 * 
 * 1. Created a function for login
 */


 function process_login($username, $password) {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return; // Exit if it's not a POST request
    }

    // Include DB connection
    require_once('dbconnect.php');
    $conn = dbconnect();

    // Sanitize username input for security purposes
    $username = htmlspecialchars(trim($username));

    // Check if both username and password are provided
    if (empty($username) || empty($password)) {
        $_SESSION["error-message"] = "Please enter both username and password";
        return;
    }

    // Attempt login for employee or customer
    if (attempt_login($conn, 'employees', $username, $password) || attempt_login($conn, 'customers', $username, $password)) {
        // Success - user logged in
        header('Location: index.php');
        exit;
    } else {
        // Failure - invalid credentials
        $_SESSION["error-message"] = "Invalid username or password";
    }
}

// Helper function to attempt login for a specific table (employees or customers)
function attempt_login($conn, $table, $username, $password) {
    // Query to fetch user data based on username
    $query = "SELECT * FROM $table WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User found, verify password
        $data = $stmt->fetch(PDO::FETCH_ASSOC); // Always use FETCH_ASSOC for security
        if (password_verify($password, $data['password'])) {
            // Store user info in session
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $data['id'];
            $_SESSION["role"] = $data["role"];
            return true;
        }
    }
    return false;
}



