<?php

require_once("functions/DashboardControllers.php");
require_once("functions/dbconnect.php");

$conn = dbconnect();

// Get user data
$user_data = index($conn);

$user = $user_data['user'];


if(empty($_SESSION["username"])){
  header("location:login.php");
  exit();
}