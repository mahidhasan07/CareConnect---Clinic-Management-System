<?php
session_start();

// 1. Check if the user is already logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    
    // If logged in, send them to their specific Dashboard
    if ($_SESSION['role'] === 'admin') {
        header("Location: View/admin_dashboard.php");
    } elseif ($_SESSION['role'] === 'doctor') {
        header("Location: View/doctor_dashboard.php");
    } elseif ($_SESSION['role'] === 'patient') {
        header("Location: View/patient_dashboard.php");
    } else {
        // Fallback if role is missing
        header("Location: View/login.php");
    }

} else {
    // 2. If NOT logged in, send them to the Landing Page (Home)
    // OLD CODE WAS: header("Location: View/login.php");
    header("Location: View/home.php"); 
}

exit();
?>