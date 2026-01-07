<?php
session_start();
require_once '../Model/UserModel.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = loginUser($email, $password);

    if ($user) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['email'] = $user['email'];
        
        // Start Session Timer
        $_SESSION['last_time'] = time(); 

        if ($user['role'] === 'admin') {
            header("Location: ../View/admin_dashboard.php");
        } elseif ($user['role'] === 'doctor') {
            header("Location: ../View/doctor_dashboard.php");
        } elseif ($user['role'] === 'patient') {
            header("Location: ../View/patient_dashboard.php");
        }
        exit();
    } else {
        header("Location: ../View/login.php?error=Invalid email or password");
        exit();
    }
} else {
    header("Location: ../View/login.php");
    exit();
}
?>