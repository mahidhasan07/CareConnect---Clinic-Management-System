<?php
require_once '../Model/UserModel.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Will always be 'patient'
    $phone = $_POST['phone'];
    
    // Capture New Fields
    $age = isset($_POST['age']) ? $_POST['age'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    
    // Specialization is null for patients
    $spec = null; 

    // Pass all data to the Model
    if (registerUser($name, $email, $password, $role, $phone, $spec, $age, $gender, $address)) {
        header("Location: ../View/login.php?msg=success");
    } else {
        echo "Error: Registration failed (Email might already exist).";
    }
} else {
    header("Location: ../View/register.php");
}
?>