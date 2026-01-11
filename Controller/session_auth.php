<?php
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: ../View/login.php");
    exit();
}

$timeout_duration = 300;

if (isset($_SESSION['last_time'])) {
    $elapsed_time = time() - $_SESSION['last_time'];
    
    if ($elapsed_time >= $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: ../View/login.php?msg=timeout");
        exit();
    }
}

$_SESSION['last_time'] = time();
?>