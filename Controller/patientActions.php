<?php
session_start();
require_once '../Model/PatientModel.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$patID = $_SESSION['user_id'];

switch ($action) {
    case 'update_profile':
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        
        if (updatePatientProfile($patID, $name, $phone, $address)) {
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

        $dayName = date('D', strtotime($date));

        if (!isTimeInSlot($docID, $dayName, $time)) {
            
            echo "<script>
                    alert('Error: The doctor is NOT available at this time on " . $dayName . ". Please check the Available Slots listed above.');
                    window.location.href='../View/patient_dashboard.php';
                  </script>";
            exit(); 
        }

        if (isSlotBooked($docID, $date, $time)) {
            echo "<script>
                    alert('Error: This time slot is already booked by another patient. Please select a different time.');
                    window.location.href='../View/patient_dashboard.php';
                  </script>";
            exit(); 
        }

        if (bookAppointment($patID, $docID, $date, $time)) {
            echo "<script>
                    alert('Appointment Booked Successfully!'); 
                    window.location.href='../View/patient_dashboard.php';
                  </script>";
        } else {
            echo "Error booking appointment";
        }
        break;

    default:
        header("Location: ../View/patient_dashboard.php");
        break;
}
?>