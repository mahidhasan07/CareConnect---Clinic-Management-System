<?php
session_start();
require_once '../Model/AdminModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email']; // We aren't updating this in DB yet, but good to have

    if (updateAdminProfile($id, $name, $email)) {
        // Update the Session Name immediately so the Dashboard updates without re-login
        $_SESSION['name'] = $name;
        
        // Redirect back to dashboard
        header("Location: ../View/admin_dashboard.php");
        exit();
    } else {
        echo "Error updating profile.";
    }
}
?>