<?php

require_once("inc.headers.php");
if($_SESSION["role"] === "admin"){
    $conn = dbconnect();

    $supplier_id = htmlspecialchars(trim($_GET["id"]));
    try{
        $sql = "SELECT * FROM suppliers WHERE supplier_id = :supplier_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':supplier_id', $supplier_id);
        $stmt->execute();
        $supplier = $stmt->fetch();
        if(!$supplier["supplier_id"]){
            echo "<script>alert('You are trying to delete an invalid supplier');</script>";
            header("Location: index.php");
            exit();
        }else{
            // Delete if existed in database
            $sql = "DELETE FROM suppliers WHERE supplier_id = :supplier_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->execute();
            $conn = null;
            echo "<script>alert('Supplier deleted successfully'); window.location ='supplier-management.php';</script>";
            // header("Location: index.php");
            // exit();
        }

    }catch(PDOException $error){
        echo $error->getMessage();
    }
    return;
}else{
    header("Location: index.php");
    exit();
}