<?php
session_start();
require_once '../Model/PatientModel.php';

// Security Check
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$patID = $_SESSION['user_id'];
$profile = getPatientProfile($patID);
$myAppts = getPatientAppointments($patID);
$myPrescs = getPatientPrescriptions($patID);
$doctors = getAllDoctors();
$slotsResult = getAllDoctorSlots();

// Organize Slots by Doctor ID for easy display
$doctorSlots = [];
if ($slotsResult->num_rows > 0) {
    while($row = $slotsResult->fetch_assoc()) {
        $doctorSlots[$row['DoctorID']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Patient Dashboard</title>
  <link rel="stylesheet" href="../Asset/patient_style.css" />
</head>
<body>

<div class="container">
  <aside class="sidebar">
    <div class="sidebar-header"><h2>Patient Portal</h2></div>
    <nav class="sidebar-menu">
      <button onclick="showSection('dashboard')">1. Dashboard Overview</button>
      <button onclick="showSection('profile')">2. My Profile</button>
      <button onclick="showSection('search')">3. Search Doctors</button>
      <button onclick="showSection('appointments')">4. My Appointments</button>
      <button onclick="showSection('prescriptions')">5. View Prescriptions</button>
    </nav>
    <button onclick="logout()" class="logout-btn">Log Out</button>
  </aside>

  <main class="main-content">
    
    <section id="dashboard" class="section active">
      <h1>Welcome Back, <?php echo $profile['FullName']; ?>!</h1>
      <div class="card-grid" style="flex-direction: row; flex-wrap: wrap;">
        <div class="card" style="width: 200px; text-align: center;">
            <h3>Appts</h3>
            <p style="font-size: 2rem; font-weight: bold; color: #2c3e50;"><?php echo $myAppts->num_rows; ?></p>
        </div>
        <div class="card" style="width: 200px; text-align: center;">
            <h3>Prescriptions</h3>
            <p style="font-size: 2rem; font-weight: bold; color: #2c3e50;"><?php echo $myPrescs->num_rows; ?></p>
        </div>
      </div>
    </section>

    <section id="profile" class="section">
      <h1>My Profile</h1>
      <div class="form-box">
        <form action="../Controller/patientActions.php" method="POST">
            <input type="hidden" name="action" value="update_profile">
            <label>Full Name</label><input name="name" value="<?php echo $profile['FullName']; ?>" required />
            <label>Email (Read Only)</label><input value="<?php echo $_SESSION['email']; ?>" readonly />
            <label>Phone Number</label><input name="phone" value="<?php echo $profile['PhoneNumber']; ?>" required />
            <label>Address</label><input name="address" value="<?php echo $profile['Address']; ?>" required />
            <label>Medical History</label><textarea name="history" rows="3"><?php echo isset($profile['MedicalHistory']) ? $profile['MedicalHistory'] : ''; ?></textarea>
            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
      </div>
    </section>

    <section id="search" class="section">
      <h1>Book Appointment</h1>
      <div class="card-grid">
        <?php while($doc = $doctors->fetch_assoc()) { 
            $docID = $doc['DoctorID'];
        ?>
            <div class="card">
                <h3><?php echo $doc['FullName']; ?> <small style="font-size:14px; color:#777;">(<?php echo $doc['Specialization']; ?>)</small></h3>
                <p><b>Visit Fee:</b> <?php echo $doc['VisitFee']; ?> BDT</p>
                
                <div style="background:#f9f9f9; padding:10px; border-radius:5px; margin:10px 0;">
                    <strong>Available Slots:</strong>
                    <?php if (isset($doctorSlots[$docID])) { ?>
                        <ul style="margin:5px 0 10px 20px; padding:0; font-size:14px;">
                            <?php foreach($doctorSlots[$docID] as $slot) { ?>
                                <li><?php echo $slot['Days'] . ": " . date("g:i A", strtotime($slot['StartTime'])) . " - " . date("g:i A", strtotime($slot['EndTime'])); ?></li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p style="color:red; font-size:14px;">No availability set.</p>
                    <?php } ?>
                </div>

                <form action="../Controller/patientActions.php" method="POST">
                    <input type="hidden" name="action" value="book_appt">
                    <input type="hidden" name="doc_id" value="<?php echo $docID; ?>">
                    
                    <label style="font-size:14px;">Select Date:</label>
                    <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                    
                    <label style="font-size:14px;">Select Time:</label>
                    <input type="time" name="time" required>
                    
                    <button type="submit" class="action-btn book-btn">Book Appointment</button>
                </form>
            </div>
        <?php } ?>
      </div>
    </section>

    <section id="appointments" class="section">
      <h1>My Appointments</h1>
      <div class="card-grid">
        <?php $myAppts->data_seek(0); while($row = $myAppts->fetch_assoc()) { ?>
            <div class="card">
                <h3><?php echo $row['DoctorName']; ?> (<?php echo $row['Specialization']; ?>)</h3>
                <p><b>Date:</b> <?php echo $row['Date'] . " at " . $row['Time']; ?></p>
                <p><b>Status:</b> <?php echo $row['Status']; ?></p>
            </div>
        <?php } ?>
      </div>
    </section>

    <section id="prescriptions" class="section">
      <h1>My Prescriptions</h1>
      <div class="card-grid">
        <?php $myPrescs->data_seek(0); while($row = $myPrescs->fetch_assoc()) { ?>
            <div class="card" style="border-top-color: #27ae60;">
                <h3>Dr. <?php echo $row['DoctorName']; ?></h3>
                <p><b>Medicine:</b> <?php echo $row['MedicineName']; ?></p>
                <p><b>Dosage:</b> <?php echo $row['Dosage']; ?> for <?php echo $row['Duration']; ?></p>
                <p><b>Date:</b> <?php echo $row['Date']; ?></p>
            </div>
        <?php } ?>
      </div>
    </section>

  </main>
</div>
<script src="../Asset/patient_script.js"></script>
</body>
</html>