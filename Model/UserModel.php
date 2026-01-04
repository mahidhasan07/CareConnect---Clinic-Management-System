<?php
require_once 'db.php';

function loginUser($email, $password) {
    global $conn;
    $sql = "SELECT * FROM Login WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $role = $user['Role'];
        $name = "User";
        $userId = 0;

        if ($role === 'admin') {
            $q = $conn->prepare("SELECT FullName, AdminID FROM Admin WHERE AdminID = ?");
            $q->bind_param("i", $user['AdminID']);
            $q->execute();
            $data = $q->get_result()->fetch_assoc();
            $name = $data['FullName'];
            $userId = $data['AdminID'];
        } elseif ($role === 'doctor') {
            $q = $conn->prepare("SELECT FullName, DoctorID FROM Doctor WHERE DoctorID = ?");
            $q->bind_param("i", $user['DoctorID']);
            $q->execute();
            $data = $q->get_result()->fetch_assoc();
            $name = $data['FullName'];
            $userId = $data['DoctorID'];
        } elseif ($role === 'patient') {
            $q = $conn->prepare("SELECT FullName, PatientID FROM Patient WHERE PatientID = ?");
            $q->bind_param("i", $user['PatientID']);
            $q->execute();
            $data = $q->get_result()->fetch_assoc();
            $name = $data['FullName'];
            $userId = $data['PatientID'];
        }

        return ['id' => $userId, 'name' => $name, 'role' => $role, 'email' => $email];
    }
    return false;
}

// UPDATED FUNCTION: Added $age, $gender, $address arguments
function registerUser($name, $email, $password, $role, $phone, $spec, $age = null, $gender = null, $address = null) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $conn->begin_transaction();

    try {
        if ($role === 'admin') {
            $stmt = $conn->prepare("INSERT INTO Admin (FullName, PhoneNumber, Email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $phone, $email);
            $stmt->execute();
            $last_id = $conn->insert_id;
            
            $stmt2 = $conn->prepare("INSERT INTO Login (Email, Password, Role, AdminID) VALUES (?, ?, 'admin', ?)");
            $stmt2->bind_param("ssi", $email, $hashed_password, $last_id);
            $stmt2->execute();

        } elseif ($role === 'doctor') {
            $stmt = $conn->prepare("INSERT INTO Doctor (FullName, PhoneNumber, Specialization) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $phone, $spec);
            $stmt->execute();
            $last_id = $conn->insert_id;
            
            $stmt2 = $conn->prepare("INSERT INTO Login (Email, Password, Role, DoctorID) VALUES (?, ?, 'doctor', ?)");
            $stmt2->bind_param("ssi", $email, $hashed_password, $last_id);
            $stmt2->execute();

        } elseif ($role === 'patient') {
            // UPDATED QUERY: Now inserts Age, Gender, and Address
            $stmt = $conn->prepare("INSERT INTO Patient (FullName, PhoneNumber, Age, Gender, Address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $name, $phone, $age, $gender, $address);
            $stmt->execute();
            $last_id = $conn->insert_id;

            $stmt2 = $conn->prepare("INSERT INTO Login (Email, Password, Role, PatientID) VALUES (?, ?, 'patient', ?)");
            $stmt2->bind_param("ssi", $email, $hashed_password, $last_id);
            $stmt2->execute();
        }
        
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}
?>