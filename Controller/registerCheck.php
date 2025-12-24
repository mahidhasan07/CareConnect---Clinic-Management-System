<?php
require_once '../Model/UserModel.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $spec = isset($_POST['specialization']) ? $_POST['specialization'] : '';

    if (registerUser($name, $email, $password, $role, $phone, $spec)) {
        header("Location: ../View/login.php?msg=success");
    } else {
        echo "Error in registration.";
    }
} else {
    header("Location: ../View/register.php");
}
?>