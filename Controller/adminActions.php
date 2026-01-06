<?php
session_start();
require_once '../Model/AdminModel.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'add_doctor') {
    // Logic to insert into DB via Model
    header("Location: ../View/admin_dashboard.php?success=1");
}
// Add other actions like delete_doctor, add_medicine etc.
?>