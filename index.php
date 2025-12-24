<?php
session_start();

// 1. Check if the user is already logged in
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    
    // 2. Redirect to the specific dashboard based on their role
    if ($_SESSION['role'] === 'admin') {
        header("Location: View/admin_dashboard.php");
    } elseif ($_SESSION['role'] === 'doctor') {
        header("Location: View/doctor_dashboard.php");
    } elseif ($_SESSION['role'] === 'patient') {
        header("Location: View/patient_dashboard.php");
    } else {
        // Fallback if role is undefined
        header("Location: View/login.php");
    }

} else {
    // 3. If not logged in, go to the Login Page
    header("Location: View/login.php");
}

exit();
?>