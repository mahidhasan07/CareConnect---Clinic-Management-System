<?php
require_once '../Model/AdminModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $strength = $_POST['strength'];
    $maker = $_POST['maker'];

    if (updateMedicine($id, $name, $type, $strength, $maker)) {
        header("Location: ../View/admin_dashboard.php?msg=updated");
    } else {
        echo "Error updating medicine.";
    }
}
?>