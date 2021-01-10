<?php
//Credit to https://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL for this login handing structure (Hihgly Modified)
include_once 'db-connect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['DeviceName'], $_POST['DeviceID'])) {
    // $DeviceName = $_POST['DeviceName'];
    $DeviceID = $_POST['DeviceID'];
    $UserID=$_SESSION['uid'];
    $onDevice=ondevicesFromuIdAndDevId($UserID, $DeviceID, $conn);

    if ($onDevice == "0") {
        // addDevice success 
        header('Location: ../membersArea.php');
    } else  if ($onDevice == "1") {
        // addDevice failed 
        header('Location: ../membersArea.php?error=1&DeviceID='.$DeviceID);
    }else {
        header('Location: ../membersArea.php?error=2&DeviceID='.$DeviceID);
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}