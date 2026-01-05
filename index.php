<?php
session_start();

// 1. Check if user is logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    
    // Redirect to Dashboard based on Role
    if ($_SESSION['role'] === 'admin') {
        header("Location: View/admin_dashboard.php");
    } elseif ($_SESSION['role'] === 'doctor') {
        header("Location: View/doctor_dashboard.php");
    } elseif ($_SESSION['role'] === 'patient') {
        header("Location: View/patient_dashboard.php");
    } else {
        header("Location: View/login.php");
    }

} else {
    // 2. If NOT logged in, go to the Home Page (Landing Page)
    header("Location: View/home.php");
}

exit();
?>