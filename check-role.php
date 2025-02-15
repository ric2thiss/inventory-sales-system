<?php
session_start();

if(isset($_SESSION["username"])){
    $role = $_SESSION["role"];
    if(empty($role)){
        echo "You are a customer";
    }else{
        header("Location: index.php");
        exit();
    }
}else{
    header("Location: login.php");
    exit();
}
