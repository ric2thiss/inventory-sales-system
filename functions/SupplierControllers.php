<?php

function get_suppliers($conn){
    try{
        $sql = "SELECT * FROM suppliers";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            $suppliers = $stmt->fetchAll();
            return $suppliers;
        }else{
            return null;
        }
        
    }catch(PDOException $error){
        echo $error->getMessage();
    }
}
function insert_supplier($conn, $employee_id, $supplier_name, $contact_person, $contact_number, $address) {
    if (empty($employee_id) || empty($supplier_name) || empty($contact_person) || empty($contact_number) || empty($address)) {
        echo "<script>alert('All input fields are required. Please fill them out.');</script>";
        return false; // Stop execution and return false
    }

    try {
        $sql = "INSERT INTO suppliers (employee_id, supplier_name, contact_person, contact_number, address)
                VALUES(:employee_id, :supplier_name, :contact_person, :contact_number, :address)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':contact_person', $contact_person);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':address', $address);

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
