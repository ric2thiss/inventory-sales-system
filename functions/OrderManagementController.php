<?php


function set_order($conn, $type, $type_qty, $unit_price, $category, $additional_qty) {
    try {
        if ($type == "refill") {
            $total_price = $type_qty * $unit_price; // Calculate total price
            
            $sql = "INSERT INTO `refill_logs`(`employee_id`, `category_id`, `quantity`, `unit_price`, `total_price`) 
                    VALUES (:employee_id, :category_id, :quantity, :unit_price, :total_price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':employee_id', $_SESSION['employee_id']);
            $stmt->bindParam(':category_id', $category);
            $stmt->bindParam(':quantity', $type_qty);
            $stmt->bindParam(':unit_price', $unit_price);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->execute();
            
            return true;
        }
        return false;
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return false;
    }
}
