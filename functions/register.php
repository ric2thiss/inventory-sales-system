<?php
// Function to sanitize inputs and prevent harmful characters
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function process_register() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return; // Exit if it's not a POST request
    }

    // Include DB connection
    require_once('dbconnect.php');
    $conn = dbconnect();

    // Retrieve form data and sanitize
    $firstname = sanitize_input($_POST['firstname']);
    $lastname = sanitize_input($_POST['lastname']);
    $email = sanitize_input($_POST['email']);
    $contact_number = sanitize_input($_POST['contact_number']);
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $address = sanitize_input($_POST['address']);

    // Attempt to register
    attempt_register($conn, $firstname, $lastname, $email, $contact_number, $username, $password, $address);
}

function attempt_register($conn, $firstname, $lastname, $email, $contact_number, $username, $password, $address) {
    // Check if username already exists
    $query = "SELECT * FROM customers WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Username already taken. Please choose another username.";
        return; // Username already exists
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        return;
    }

    // Validate contact number format (e.g., assuming it's a 10-digit number)
    // if (!preg_match("/^\d{12}$/", $contact_number)) {
    //     echo "Invalid contact number. It should be 11 digits.";
    //     return;
    // }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $query = "INSERT INTO customers (firstname, lastname, email, username, password, contact_number, address) 
              VALUES (:firstname, :lastname, :email, :username, :password, :contact_number, :address)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':address', $address);

    try {
        // Execute the query
        $stmt->execute();
        echo "Customer Registration successful!";
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
