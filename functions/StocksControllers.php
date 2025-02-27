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
function insert_inventory($conn, $item_name, $category_id, $stock_quantity,$unit_price, $employee_id, $supplier_id) {
    if (empty($item_name) || empty($category_id) || empty($stock_quantity) || empty($employee_id) || empty($supplier_id)) {
        echo "<script>alert('All input fields are required. Please fill them out.');</script>";
        return false; // Stop execution and return false
    }

    try {
        $sql = "INSERT INTO `inventory`(item_name, category_id, stock_quantity, unit_price, employee_id, supplier_id)
                VALUES(:item_name, :category_id, :stock_quantity, :unit_price, :employee_id, :supplier_id)";  // Fixed the missing parenthesis
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':item_name', $item_name);
        $stmt->bindParam(':category_id', $category_id);
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

function get_category_count($conn) {
    try {
        $sql = "SELECT 
            category.category_id,
            category.category_name, 
            COUNT(inventory.inventory_id) AS item_count, 
            COALESCE(SUM(inventory.unit_price), 0) AS total_unit_price, 
            COALESCE(SUM(inventory.stock_quantity), 0) AS total_stock_quantity
        FROM category
        LEFT JOIN inventory ON category.category_id = inventory.category_id
        GROUP BY inventory.category_id, category.category_name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
}

function get_inventory($conn){
    try{
        // $sql = "SELECT 
        //             inventory.inventory_id,
        //             inventory.item_name,
        //             inventory.category_id,
        //             inventory.stock_quantity,
        //             inventory.unit_price,
        //             inventory.last_updated,
        //             category.category_name,
        //             employees.firstname,
        //             employees.lastname,
        //             suppliers.supplier_name
        //         FROM inventory
        //         LEFT JOIN category ON category.category_id = inventory.category_id
        //         LEFT JOIN employees ON employees.employee_id = inventory.employee_id
        //         LEFT JOIN suppliers ON suppliers.supplier_id = inventory.supplier_id";
        $sql = "SELECT 
            inventory.inventory_id,
            inventory.item_name,
            inventory.category_id,
            inventory.stock_quantity,
            inventory.unit_price,
            inventory.last_updated,
            category.category_name,
            employees.firstname,
            employees.lastname,
            suppliers.supplier_name,
            COUNT(*) OVER(PARTITION BY inventory.category_id) AS category_count
        FROM inventory
        LEFT JOIN category ON category.category_id = inventory.category_id
        LEFT JOIN employees ON employees.employee_id = inventory.employee_id
        LEFT JOIN suppliers ON suppliers.supplier_id = inventory.supplier_id";

        
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        return null;
        
    } catch(PDOException $error){
        echo $error->getMessage();
        return null;
    }
}

function get_category($conn, $request)
{
    try {
        if ($request == "all") {
            $sql = "SELECT * FROM category";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } 
        return null;
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
        return null;
    }
}

function insert_category($conn, $category_name)
{
    try {
        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category_name', $category_name);
        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
   
}

// function re_stock($conn, $item_id, $quantity, $purchase_price)
// {
//     try {
//         // Fetch inventory_id and supplier_id based on the given item_id
//         $stmt = $conn->prepare("SELECT inventory_id, supplier_id FROM inventory WHERE inventory_id = :item_id");
//         $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
//         $stmt->execute();
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($row) {
//             $inventory_id = $row['inventory_id'];
//             $supplier_id = $row['supplier_id'];

//             // Insert into stock_in table
//             $sql = "INSERT INTO stock_in (inventory_id, supplier_id, quantity_added, purchase_price) 
//                     VALUES (:inventory_id, :supplier_id, :quantity, :purchase_price)";
//             $stmt = $conn->prepare($sql);
//             $stmt->bindParam(':inventory_id', $inventory_id, PDO::PARAM_INT);
//             $stmt->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
//             $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
//             $stmt->bindParam(':purchase_price', $purchase_price, PDO::PARAM_STR);
//             $stmt->execute();

//             echo "Stock added successfully!";
//         } else {
//             echo "Item not found in inventory.";
//         }
//     } catch (PDOException $error) {
//         echo "Error: " . $error->getMessage();
//     }
// }


function re_stock($conn, $item_id, $quantity, $purchase_price)
{
    try {
        // Insert data into stock_in table with supplier_id fetched using a JOIN
        $sql = "INSERT INTO stock_in (inventory_id, supplier_id, quantity_added, purchase_price) 
                SELECT i.inventory_id, i.supplier_id, :quantity, :purchase_price 
                FROM inventory i 
                WHERE i.inventory_id = :item_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':purchase_price', $purchase_price, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}




