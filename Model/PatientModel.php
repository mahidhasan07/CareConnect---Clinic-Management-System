<?php
require_once 'db.php';

function getPatientProfile($id) {
    global $conn;
    $sql = "SELECT * FROM Patient WHERE PatientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getPatientAppointments($id) {
    global $conn;
    $sql = "SELECT A.AppointmentID, A.Date, A.Time, A.Status, D.FullName AS DoctorName, D.Specialization 
            FROM Appointment A 
            JOIN Doctor D ON A.DoctorID = D.DoctorID 
            WHERE A.PatientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getPatientPrescriptions($id) {
    global $conn;
    $sql = "SELECT P.Date, P.Dosage, P.Duration, M.Name AS MedicineName, D.FullName AS DoctorName 
            FROM Prescription P 
            JOIN Medicine M ON P.MedicineID = M.MedicineID 
            JOIN Doctor D ON P.DoctorID = D.DoctorID 
            WHERE P.PatientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result();
}

function getAllDoctors() {
    global $conn;
    $sql = "SELECT * FROM Doctor";
    return $conn->query($sql);
}

function updatePatientProfile($id, $name, $phone, $history, $address) {
    global $conn;
    $sql = "UPDATE Patient SET FullName = ?, PhoneNumber = ?, MedicalHistory = ?, Address = ? WHERE PatientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $phone, $history, $address, $id);
    return $stmt->execute();
}

function bookAppointment($patID, $docID, $date, $time) {
    global $conn;
    $sql = "INSERT INTO Appointment (PatientID, DoctorID, Date, Time, Status) VALUES (?, ?, ?, ?, 'Booked')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $patID, $docID, $date, $time);
    return $stmt->execute();
}

function getAllDoctorSlots() {
    global $conn;
    $sql = "SELECT * FROM AppointmentSlots ORDER BY DoctorID, FIELD(Days, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')";
    return $conn->query($sql);
}

function isTimeInSlot($docID, $dayName, $requestTime) {
    global $conn;

$sql = "SELECT * FROM AppointmentSlots WHERE DoctorID = ? AND Days = ? 
            AND ? BETWEEN StartTime AND EndTime";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $docID, $dayName, $requestTime);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

function isSlotBooked($docID, $date, $time) {
    global $conn;
    $sql = "SELECT * FROM Appointment WHERE DoctorID = ? AND Date = ? AND Time = ? 
            AND (Status = 'Booked' OR Status = 'Approved')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $docID, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

?>