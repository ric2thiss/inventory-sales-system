<?php

session_start();

// Logout all session
$_SESSION = array();
session_destroy();

if(empty($_SESSION)){
    header("Location: login.php");
    exit();
}