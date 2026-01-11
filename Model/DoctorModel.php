<?php
require_once 'db.php';


function getDoctorProfile($doctor_id) {
    global $conn;
    $sql = "SELECT * FROM Doctor WHERE DoctorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getDoctorAppointments($doctor_id, $status) {
    global $conn;
    $sql = "SELECT A.AppointmentID, A.Date, A.Time, A.Status, P.FullName, P.PatientID 
            FROM Appointment A 
            JOIN Patient P ON A.PatientID = P.PatientID 
            WHERE A.DoctorID = ? AND A.Status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $doctor_id, $status);
    $stmt->execute();
    return $stmt->get_result();
}

function getAllMedicines() {
    global $conn;
    $sql = "SELECT * FROM Medicine WHERE Status = 'Active'";
    return $conn->query($sql);
}

function getDoctorSlots($doctor_id) {
    global $conn;
    $sql = "SELECT * FROM AppointmentSlots WHERE DoctorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    return $stmt->get_result();
}


function updateDoctorProfile($id, $name, $phone, $spec) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Doctor SET FullName = ?, PhoneNumber = ?, Specialization = ? WHERE DoctorID = ?");
    $stmt->bind_param("sssi", $name, $phone, $spec, $id);
    return $stmt->execute();
}

function updateVisitFee($id, $fee) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Doctor SET VisitFee = ? WHERE DoctorID = ?");
    $stmt->bind_param("di", $fee, $id);
    return $stmt->execute();
}

function updateAppointmentStatus($appt_id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Appointment SET Status = ? WHERE AppointmentID = ?");
    $stmt->bind_param("si", $status, $appt_id);
    return $stmt->execute();
}

function addPrescription($doc_id, $pat_id, $med_id, $dosage, $duration) {
    global $conn;
    $date = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO Prescription (DoctorID, PatientID, MedicineID, Dosage, Duration, Date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $doc_id, $pat_id, $med_id, $dosage, $duration, $date);
    return $stmt->execute();
}

function addAvailability($doc_id, $day, $start, $end) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO AppointmentSlots (DoctorID, Days, StartTime, EndTime) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $doc_id, $day, $start, $end);
    return $stmt->execute();
}

function getDoctorStats($docID) {
    global $conn;
    $stats = [];
    
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM Appointment WHERE DoctorID = ?");
    $stmt->bind_param("i", $docID);
    $stmt->execute();
    $stats['appointments'] = $stmt->get_result()->fetch_assoc()['total'];

    $stmt = $conn->prepare("SELECT COUNT(DISTINCT PatientID) as total FROM Appointment WHERE DoctorID = ?");
    $stmt->bind_param("i", $docID);
    $stmt->execute();
    $stats['patients'] = $stmt->get_result()->fetch_assoc()['total'];
    
    return $stats;
}
?>