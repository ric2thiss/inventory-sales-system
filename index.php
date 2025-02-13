<?php
session_start();
// if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
//     // Connection
//     require_once("functions/dbconnect.php");
//     $conn = dbconnect();
//     $id = $_SESSION['id'];
//     $role = (!empty($_SESSION["role"]))? "employees":"customer";

//     $query = "SELECT * FROM $role WHERE id = :id";

//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':id', $id);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);

//     // Ensure the result is valid and handle accordingly
//     if ($result) {
//         if (empty($result["role"])) {
//             echo "You are a customer";
//         } else {
//             header("Location: index.html");
//             exit;
//         }
//     } else {
//         // Handle case where user with the given ID was not found
//         echo "User not found";
//     }
// }

if(isset($_SESSION["id"]) && !empty($_SESSION["id"])){
    $role = $_SESSION["role"];
    if(empty($role)){
        echo "You are a customer";
    }else{
        header("Location: index.html");
    }
}
