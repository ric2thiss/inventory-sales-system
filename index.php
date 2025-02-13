<?php
session_start();
echo $_SESSION['id'];
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    // Connection
    require_once("functions/dbconnect.php");
    $conn = dbconnect();
    $id = $_SESSION['id'];
    $role = $_SESSION["role"];

    $query = "SELECT * FROM $role WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ensure the result is valid and handle accordingly
    if ($result) {
        if (empty($result["role"])) {
            echo "You are a customer";
        } else {
            echo "You are an admin";
        }
    } else {
        // Handle case where user with the given ID was not found
        echo "User not found";
    }
}
?>
