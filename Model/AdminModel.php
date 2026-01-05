<?php
require_once 'db.php';

// --- FETCH FUNCTIONS (For Dashboard) ---

function getAllDoctors() {
    global $conn;
    $sql = "SELECT * FROM Doctor";
    return $conn->query($sql);
}

function getAllPatients() {
    global $conn;
    $sql = "SELECT * FROM Patient";
    return $conn->query($sql);
}

function getAllMedicines() {
    global $conn;
    $sql = "SELECT * FROM Medicine";
    return $conn->query($sql);
}

function getAllAppointments() {
    global $conn;
    // Joins to get names instead of IDs
    $sql = "SELECT A.AppointmentID, A.Date, A.Time, A.Status, 
                   P.FullName AS PatientName, 
                   D.FullName AS DoctorName 
            FROM Appointment A
            JOIN Patient P ON A.PatientID = P.PatientID
            JOIN Doctor D ON A.DoctorID = D.DoctorID";
    return $conn->query($sql);
}

function getDashboardCounts() {
    global $conn;
    $counts = [];
    $counts['doctors'] = $conn->query("SELECT COUNT(*) as total FROM Doctor")->fetch_assoc()['total'];
    $counts['patients'] = $conn->query("SELECT COUNT(*) as total FROM Patient")->fetch_assoc()['total'];
    $counts['medicines'] = $conn->query("SELECT COUNT(*) as total FROM Medicine")->fetch_assoc()['total'];
    $counts['appointments'] = $conn->query("SELECT COUNT(*) as total FROM Appointment")->fetch_assoc()['total'];
    return $counts;
}

// --- ACTION FUNCTIONS (For Controllers) ---

function addDoctor($name, $spec, $phone, $fee, $email, $password) {
    global $conn;
    // Transaction to add to both Doctor table and Login table
    $conn->begin_transaction();
    try {
        // 1. Add to Doctor Table
        $stmt = $conn->prepare("INSERT INTO Doctor (FullName, Specialization, PhoneNumber, VisitFee) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $name, $spec, $phone, $fee);
        $stmt->execute();
        $docID = $conn->insert_id;

        // 2. Add to Login Table
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt2 = $conn->prepare("INSERT INTO Login (Email, Password, Role, DoctorID) VALUES (?, ?, 'doctor', ?)");
        $stmt2->bind_param("ssi", $email, $hashed, $docID);
        $stmt2->execute();

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

function deleteDoctor($id) {
    global $conn;
    // Cascade delete in SQL usually handles Login/Appointments, 
    // but good practice to delete directly
    $stmt = $conn->prepare("DELETE FROM Doctor WHERE DoctorID = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function addMedicine($name, $type, $strength, $maker) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Medicine (Name, Type, Strength, ManufacturerName, Status) VALUES (?, ?, ?, ?, 'Active')");
    $stmt->bind_param("ssss", $name, $type, $strength, $maker);
    return $stmt->execute();
}

function deleteMedicine($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM Medicine WHERE MedicineID = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function updateAdminProfile($id, $name, $email) {
    global $conn;
    // Update Admin Table (Name)
    $stmt = $conn->prepare("UPDATE Admin SET FullName = ? WHERE AdminID = ?");
    $stmt->bind_param("si", $name, $id);
    
    // Note: Updating Email is complex because it's in both Admin and Login tables.
    // For now, we will just update the Name to keep it simple and safe.
    
    return $stmt->execute();
}

// ... (keep existing code) ...

// --- UPDATE FUNCTIONS ---

function updateDoctor($id, $name, $spec, $phone, $fee) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Doctor SET FullName=?, Specialization=?, PhoneNumber=?, VisitFee=? WHERE DoctorID=?");
    $stmt->bind_param("sssdi", $name, $spec, $phone, $fee, $id);
    return $stmt->execute();
}

function updateMedicine($id, $name, $type, $strength, $maker) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Medicine SET Name=?, Type=?, Strength=?, ManufacturerName=? WHERE MedicineID=?");
    $stmt->bind_param("ssssi", $name, $type, $strength, $maker, $id);
    return $stmt->execute();
}
?>
