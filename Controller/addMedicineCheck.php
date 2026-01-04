<?php
require_once '../Model/AdminModel.php';

if (isset($_POST['add_medicine'])) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $strength = $_POST['strength'];
    $maker = $_POST['maker'];

    if (addMedicine($name, $type, $strength, $maker)) {
        header("Location: ../View/admin_dashboard.php");
    } else {
        echo "Error adding medicine.";
    }
}
?>