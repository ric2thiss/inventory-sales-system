<?php

// function get_suppliers($conn){
//     try{
//         $sql = "SELECT * FROM suppliers";
//         $stmt = $conn->prepare($sql);
//         if($stmt->execute()){
//             $suppliers = $stmt->fetchAll();
//             return $suppliers;
//         }else{
//             return null;
//         }
        
//     }catch(PDOException $error){
//         echo $error->getMessage();
//     }
// }
function insert_inventory($conn, $item_name, $category, $stock_quantity,$unit_price, $employee_id, $supplier_id) {
    if (empty($item_name) || empty($category) || empty($stock_quantity) || empty($employee_id) || empty($supplier_id)) {
        echo "<script>alert('All input fields are required. Please fill them out.');</script>";
        return false; // Stop execution and return false
    }

    try {
        $sql = "INSERT INTO `inventory`(item_name, category, stock_quantity, unit_price, employee_id, supplier_id)
                VALUES(:item_name, :category, :stock_quantity, :unit_price, :employee_id, :supplier_id)";  // Fixed the missing parenthesis
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':item_name', $item_name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':unit_price', $unit_price);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':supplier_id', $supplier_id);

        if ($stmt->execute()) {
            return true; // Success
        } else {
            return false; // Query failed
        }
    } catch (PDOException $error) {
        echo "<script>alert('SQL Error: " . addslashes($error->getMessage()) . "');</script>";
        return false; // SQL error occurred
    }
}

function get_inventory($conn){
    try{
        $sql = "SELECT * FROM inventory";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            $inventory = $stmt->fetchAll();
            return $inventory;
        }else{
            return null;
        }
        
    }catch(PDOException $error){
        echo $error->getMessage();
    }
}

