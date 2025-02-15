<?php


/**
 * 1. Get all necessary data to load in dashboard
 * 2. Load dashboard
 */

 function index($conn){
    // 1. Get all necessary data to load in dashboard
    $data = array(
        'title' => 'Dashboard',
        'user' => get_user($conn, $_SESSION["username"]),
        
        );
        
        return $data;
        
 }

 function get_user($conn, $username) {
    // Check if the session role is set and use it to decide the table
    $table = isset($_SESSION["role"]) && !empty($_SESSION["role"]) ? 'employees' : 'customers';

    try {
        // Prepare the SQL query
        $query = "SELECT * FROM $table WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Fetch user data
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the user data
        return $user;
    } catch(PDOException $e) {
        // Handle errors and display message
        echo "Error: " . $e->getMessage();
        
        // Return an empty array in case of error
        return [];
    }
}