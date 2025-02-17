<?php


/**
 * 1. Get all necessary data to load in dashboard
 * 2. Load dashboard
 */

 session_start(); 

 function index($conn) {
     // 1. Get all necessary data to load in dashboard
     return [
         'title' => 'Dashboard',
         'user' => get_user($conn, $_SESSION["username"]),
     ];
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
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
         
         // Return the user data (or null if not found)
         return $user ?: null;
     } catch(PDOException $e) {
         // Handle errors and display message
         echo "Error: " . $e->getMessage();
         
         // Return null in case of error
         return null;
     }
 }


//  Update Method for users profile page
function update_user_personal_details($conn, $address, $contact_number){
    $table = isset($_SESSION["role"]) && !empty($_SESSION["role"]) ? 'employees' : 'customers';

    try{
        $query = "UPDATE $table SET address = :address, contact_number= :contact_number";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->execute();
        return true;
    }catch(PDOException $error){
        echo "Error: " . $error->getMessage();
        return null;
    }
}

function update_user_personal_password($conn, $id, $current_password, $new_password) {
    $table = isset($_SESSION["role"]) && !empty($_SESSION["role"]) ? 'employees' : 'customers';
    $id_column = $table === 'employees' ? 'employee_id' : 'customer_id';

    try {
        // Fetch current password
        $query1 = "SELECT password FROM $table WHERE $id_column = :id";
        $stmt = $conn->prepare($query1);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debugging output
        if (!$user) {
            echo "User not found!";
            return false;
        }

        // var_dump($current_password, $user["password"]); // Debug password check

        if (password_verify($current_password, $user["password"])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $query = "UPDATE $table SET password = :password WHERE $id_column = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            return true;
        } else {
            echo "Password verification failed!";
        }

        return false;
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return null;
    }
}

