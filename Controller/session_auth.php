<?php
session_start();

// 1. Check if user is logged in
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: ../View/login.php");
    exit();
}

// 5 min for testing. 
$timeout_duration = 300;

// 3. Check if the session has expired
if (isset($_SESSION['last_time'])) {
    $elapsed_time = time() - $_SESSION['last_time'];
    
    if ($elapsed_time >= $timeout_duration) {
        // Session expired
        session_unset();
        session_destroy();
        header("Location: ../View/login.php?msg=timeout");
        exit();
    }
}

// 4. Update the "Last Activity" time stamp
$_SESSION['last_time'] = time();
?>