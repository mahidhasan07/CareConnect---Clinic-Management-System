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

        // Redirect based on Role
        if ($user['role'] === 'admin') {
            header("Location: ../View/admin_dashboard.php");
        } elseif ($user['role'] === 'doctor') {
            header("Location: ../View/doctor_dashboard.php");
        } elseif ($user['role'] === 'patient') {
            header("Location: ../View/patient_dashboard.php");
        }
        exit();
    } else {
        echo "Invalid Credentials. <a href='../View/login.php'>Try Again</a>";
    }
} else {
    header("Location: ../View/login.php");
}
?>