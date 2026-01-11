<?php
require_once '../Model/AdminModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $spec = $_POST['spec'];
    $phone = $_POST['phone'];
    $fee = $_POST['fee'];

    if (updateDoctor($id, $name, $spec, $phone, $fee)) {
        header("Location: ../View/admin_dashboard.php?msg=updated");
    } else {
        echo "Error updating doctor.";
    }
}
?>