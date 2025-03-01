<?php


function set_order($conn, $type, $type_qty, $category, $additional_qty){
    try{
        $sql = "";
        if($type == "refill"){
            $sql = "INSERT INTO refill_logs (type, type_qty, category, additional_qty) VALUES (:type, :type_qty, :category, :additional_qty)";
            
        }
    }catch(PDOException $error){
        echo "Error: " . $error->getMessage();
        return false;
    }
}