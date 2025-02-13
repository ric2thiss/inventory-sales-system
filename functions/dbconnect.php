<?php

/****
 * 
 * 1. Created Database Connection using PDO
 * 2. Created a function to insert data into the database
 * 
 */

function dbconnect(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory-sales-system";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
            
    
 }

// For testing purpose
//  if(dbconnect()){
//     echo "You are connected!";
//  }else{
//     echo "Connection failed";
//  }