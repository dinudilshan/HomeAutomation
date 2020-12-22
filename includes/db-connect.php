<?php
$servername = "un0jueuv2mam78uv.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306";
$username = "jgeuutxg2d8tkfoy";
$password = "i0vkhagxtxbnvm83";

try {
    $conn = new PDO("mysql:host=$servername;dbname=zze1i2jqrv0grugh", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    header('Location: ./setup.php');
    //echo "Connection failed: " . $e->getMessage();
    }
    
?> 