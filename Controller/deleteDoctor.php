<?php
require_once '../Model/AdminModel.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (deleteDoctor($id)) {
        header("Location: ../View/admin_dashboard.php");
    } else {
        echo "Error deleting doctor.";
    }
}
?>