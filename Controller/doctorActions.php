<?php
session_start();
require_once '../Model/DoctorModel.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$docID = $_SESSION['user_id'];

switch ($action) {
    
    case 'update_profile':
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $spec = $_POST['spec'];
        if (updateDoctorProfile($docID, $name, $phone, $spec)) {
            $_SESSION['name'] = $name; 
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error updating profile"; }
        break;

    case 'update_fee':
        $fee = $_POST['fee'];
        if (updateVisitFee($docID, $fee)) {
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error updating fee"; }
        break;

    case 'approve':
        $id = $_GET['id'];
        if (updateAppointmentStatus($id, 'Approved')) {
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error approving"; }
        break;

    case 'reject':
        $id = $_GET['id'];
        if (updateAppointmentStatus($id, 'Cancelled')) {
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error rejecting"; }
        break;

    case 'add_slot':
        $day = $_POST['day'];
        $start = $_POST['start'];
        $end = $_POST['end'];

        if (addAvailability($docID, $day, $start, $end)) {
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error adding slot"; }
        break;

    case 'add_prescription':
        $patID = $_POST['patient_id'];
        $medID = $_POST['medicine_id'];
        $dosage = $_POST['dosage'];
        $duration = $_POST['duration'];
        if (addPrescription($docID, $patID, $medID, $dosage, $duration)) {
            header("Location: ../View/doctor_dashboard.php");
        } else { echo "Error adding prescription (Check if Patient ID exists)"; }
        break;

    default:
        header("Location: ../View/doctor_dashboard.php");
        break;
}
?>