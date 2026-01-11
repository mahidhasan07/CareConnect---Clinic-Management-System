<?php
require_once '../Model/AdminModel.php';

if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $spec = $_POST['spec'];
    $phone = $_POST['phone'];
    $fee = $_POST['fee'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (addDoctor($name, $spec, $phone, $fee, $email, $pass)) {
        header("Location: ../View/admin_dashboard.php");
    } else {
        echo "Error adding doctor.";
    }
}
?>