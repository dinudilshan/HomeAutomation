<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "1234";

try {
    $conn = new PDO("mysql:host=$servername;dbname=home_auto", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    header('Location: ./setup.php');
    //echo "Connection failed: " . $e->getMessage();
    }
    
?> 