<?php


function set_order($conn, $type, $type_qty, $category, $additional_qty){
    try{
        $sql = "";
        if($type == "refill"){
            $sql = "INSERT INTO `refill_logs`(`employee_id`, `refill_date`, `quantity`, `unit_price`, `total_price`)";
            
        }
    }catch(PDOException $error){
        echo "Error: " . $error->getMessage();
        return false;
    }
}