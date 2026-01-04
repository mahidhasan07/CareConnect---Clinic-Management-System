<?php
require_once '../Model/AdminModel.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (deleteMedicine($id)) {
        header("Location: ../View/admin_dashboard.php");
    } else {
        echo "Error deleting medicine.";
    }
}
?>