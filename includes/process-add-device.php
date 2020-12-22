<?php
//Credit to https://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL for this login handing structure (Hihgly Modified)
include_once 'db-connect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['DeviceName'], $_POST['DeviceID'])) {
    $DeviceName = $_POST['DeviceName'];
    $DeviceID = $_POST['DeviceID']; // The hashed password.
    $uid=$_SESSION['uid'];
    $addDevice=addDevice($DeviceName, $DeviceID, $uid, $conn);

    if ($addDevice == "0") {
        // addDevice success 
        header('Location: ../membersArea.php');
    } else  if ($addDevice == "1") {
        // addDevice failed 
        header('Location: ../add-device.php?error=1&deviceName='.$DeviceName);
    }else {
        header('Location: ../add-device.php?error=2&deviceName='.$DeviceName);
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}