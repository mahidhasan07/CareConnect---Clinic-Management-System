<?php
session_start();
require_once '../Model/AdminModel.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'add_doctor') {
    header("Location: ../View/admin_dashboard.php?success=1");
}

?>