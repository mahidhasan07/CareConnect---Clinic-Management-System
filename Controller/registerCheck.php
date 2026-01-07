<?php
session_start();
require_once '../Model/UserModel.php';

if (isset($_POST['submit'])) {
    // Trim inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; 
    $phone = trim($_POST['phone']);
    $age = isset($_POST['age']) ? trim($_POST['age']) : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    $spec = null; 

   
    $user_data = "name=" . urlencode($name) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&age=" . urlencode($age) . "&gender=" . urlencode($gender) . "&address=" . urlencode($address);

    // --- VALIDATION LOGIC START ---

    // 1. Validate Name
    if (empty($name)) {
        header("Location: ../View/register.php?error=Name cannot be empty&$user_data");
        exit();
    }
    if (!ctype_alpha($name[0])) {
        header("Location: ../View/register.php?error=Name must start with a letter&$user_data");
        exit();
    }
    if (!preg_match('/^[a-zA-Z .\-]+$/', $name)) {
        header("Location: ../View/register.php?error=Name contains invalid characters&$user_data");
        exit();
    }
    if (str_word_count($name) < 2) {
        header("Location: ../View/register.php?error=Name must contain at least two words&$user_data");
        exit();
    }

    // 2. Validate Email
    if (empty($email)) {
        header("Location: ../View/register.php?error=Email cannot be empty&$user_data");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../View/register.php?error=Invalid email address format&$user_data");
        exit();
    }

    // 3. Validate Phone Number
    if (empty($phone)) {
        header("Location: ../View/register.php?error=Phone number cannot be empty&$user_data");
        exit();
    }
    if (!preg_match('/^01[0-9]{9}$/', $phone)) {
        header("Location: ../View/register.php?error=Phone must be 11 digits and start with 01&$user_data");
        exit();
    }

    // 4. Validate Address
    if (empty($address)) {
        header("Location: ../View/register.php?error=Address cannot be empty&$user_data");
        exit();
    }
    if (strlen($address) < 5) {
        header("Location: ../View/register.php?error=Please enter a valid, full address&$user_data");
        exit();
    }

    // 5. Validate Password
    if (strlen($password) < 8) {
        header("Location: ../View/register.php?error=Password must be at least 8 characters&$user_data");
        exit();
    }
    if (!preg_match('/[A-Z]/', $password)) {
        header("Location: ../View/register.php?error=Password must contain at least one capital letter&$user_data");
        exit();
    }
    if (!preg_match('/[0-9]/', $password)) {
        header("Location: ../View/register.php?error=Password must contain at least one number&$user_data");
        exit();
    }
    if (!preg_match('/[\W_]/', $password)) {
        header("Location: ../View/register.php?error=Password must contain at least one special character&$user_data");
        exit();
    }

    // --- VALIDATION LOGIC END ---

    if (registerUser($name, $email, $password, $role, $phone, $spec, $age, $gender, $address)) {
        header("Location: ../View/login.php?msg=success");
    } else {
        header("Location: ../View/register.php?error=Email already exists or System Error&$user_data");
    }
} else {
    header("Location: ../View/register.php");
}
?>