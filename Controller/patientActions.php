<?php
session_start();
require_once '../Model/PatientModel.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$patID = $_SESSION['user_id'];

switch ($action) {
    case 'update_profile':
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $history = $_POST['history'];
        $address = $_POST['address'];
        
        if (updatePatientProfile($patID, $name, $phone, $history, $address)) {
            $_SESSION['name'] = $name; // Update session name
            header("Location: ../View/patient_dashboard.php");
        } else {
            echo "Error updating profile";
        }
        break;

    case 'book_appt':
        $docID = $_POST['doc_id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        
        if (bookAppointment($patID, $docID, $date, $time)) {
            // Success! Redirect back to dashboard
            echo "<script>alert('Appointment Booked!'); window.location.href='../View/patient_dashboard.php';</script>";
        } else {
            echo "Error booking appointment";
        }
        break;

    default:
        header("Location: ../View/patient_dashboard.php");
        break;
}
?>