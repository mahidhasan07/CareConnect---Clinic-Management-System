<?php
session_start();
require_once '../Model/DoctorModel.php';

// Security Check
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$docID = $_SESSION['user_id'];
$profile = getDoctorProfile($docID);
$pendingAppts = getDoctorAppointments($docID, 'Booked');
$historyAppts = getDoctorAppointments($docID, 'Approved');
$medicines = getAllMedicines();
$slots = getDoctorSlots($docID);
$stats = getDoctorStats($docID); // Fetch stats for dashboard
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Dashboard</title>
  <link rel="stylesheet" href="../Asset/doctor_style.css" />
</head>
<body>

<div class="container">
  <aside class="sidebar">
    <div class="sidebar-header"><h2>Doctor Dashboard</h2></div>
    <nav class="sidebar-menu">
      <button onclick="showSection('dashboard')">1. Dashboard Overview</button>
      <button onclick="showSection('profile')">2. My Profile</button>
      <button onclick="showSection('availability')">3. Availability</button>
      <button onclick="showSection('appointments')">4. Appointments</button>
      <button onclick="showSection('history')">5. Patient History</button>
      <button onclick="showSection('prescription')">6. Write Prescription</button>
      <button onclick="showSection('fee')">7. Update Visit Fee</button>
    </nav>
    <button onclick="logout()" class="logout-btn">Log Out</button>
  </aside>

  <main class="main-content">
    
    <section id="dashboard" class="section active">
      <h1>Welcome, <?php echo $profile['FullName']; ?>!</h1>
      <div class="card-grid" style="flex-direction: row; flex-wrap: wrap;">
        <div class="card" style="width: 250px; text-align: center;">
            <h3>Total Appointments</h3>
            <p style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;"><?php echo $stats['appointments']; ?></p>
        </div>
        <div class="card" style="width: 250px; text-align: center;">
            <h3>Total Patients</h3>
            <p style="font-size: 2.5rem; font-weight: bold; color: #2c3e50;"><?php echo $stats['patients']; ?></p>
        </div>
        <div class="card" style="width: 250px; text-align: center;">
            <h3>Pending Requests</h3>
            <p style="font-size: 2.5rem; font-weight: bold; color: #e67e22;"><?php echo $pendingAppts->num_rows; ?></p>
        </div>
      </div>
    </section>

    <section id="profile" class="section">
      <h1>My Profile</h1>
      <div class="form-box">
        <form action="../Controller/doctorActions.php" method="POST">
            <input type="hidden" name="action" value="update_profile">
            <label>Name</label><input name="name" value="<?php echo $profile['FullName']; ?>" required />
            <label>Phone</label><input name="phone" value="<?php echo $profile['PhoneNumber']; ?>" required />
            <label>Specialization</label><input name="spec" value="<?php echo $profile['Specialization']; ?>" required />
            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
      </div>
    </section>

    <section id="availability" class="section hidden">
      <h1>Manage Availability</h1>
      <div class="form-box">
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 10px;">Add new time slots for your patients.</p>
        <form action="../Controller/doctorActions.php" method="POST" style="display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
            <input type="hidden" name="action" value="add_slot">
            <div>
                <label>Day</label>
                <select name="day" style="padding:10px; width:120px;">
                    <option value="Mon">Monday</option><option value="Tue">Tuesday</option>
                    <option value="Wed">Wednesday</option><option value="Thu">Thursday</option>
                    <option value="Fri">Friday</option><option value="Sat">Saturday</option>
                    <option value="Sun">Sunday</option>
                </select>
            </div>
            <div><label>Start Time</label><input type="time" name="start" required /></div>
            <div><label>End Time</label><input type="time" name="end" required /></div>
            <button type="submit" class="btn-success" style="height:40px; margin-bottom:15px;">+ Add Slot</button>
        </form>
      </div>

      <h3 style="margin-top:20px;">Current Slots</h3>
      <div class="card-grid">
        <?php if ($slots->num_rows > 0) {
            while($row = $slots->fetch_assoc()) { ?>
                <div class="card" style="padding: 10px; border-left: 4px solid #27ae60;">
                    <b><?php echo $row['Days']; ?>:</b> <?php echo date("g:i A", strtotime($row['StartTime'])) . " - " . date("g:i A", strtotime($row['EndTime'])); ?>
                </div>
        <?php }} else { echo "<p>No slots added yet.</p>"; } ?>
      </div>
    </section>

    <section id="appointments" class="section hidden">
      <h1>Appointment Requests</h1>
      <div class="card-grid">
        <?php if ($pendingAppts->num_rows > 0) { 
            while($row = $pendingAppts->fetch_assoc()) { ?>
            <div class="card">
                <h3><?php echo $row['FullName']; ?> (ID: <?php echo $row['PatientID']; ?>)</h3>
                <p><b>When:</b> <?php echo $row['Date'] . " at " . $row['Time']; ?></p>
                <div style="margin-top:10px;">
                    <a href="../Controller/doctorActions.php?action=approve&id=<?php echo $row['AppointmentID']; ?>" class="action-btn approve-btn" style="text-decoration:none;">Approve</a>
                    <a href="../Controller/doctorActions.php?action=reject&id=<?php echo $row['AppointmentID']; ?>" class="action-btn reject-btn" style="text-decoration:none;">Reject</a>
                </div>
            </div>
        <?php }} else { echo "<p>No pending requests.</p>"; } ?>
      </div>
    </section>

    <section id="history" class="section hidden">
      <h1>Patient History</h1>
      <div class="card-grid">
        <?php if ($historyAppts->num_rows > 0) { 
            while($row = $historyAppts->fetch_assoc()) { ?>
            <div class="card" style="border-top-color: #27ae60;">
                <h3><?php echo $row['FullName']; ?></h3>
                <p><?php echo $row['Date'] . " - " . $row['Time']; ?></p>
                <p style="color:#27ae60; font-weight:bold;">Confirmed</p>
            </div>
        <?php }} else { echo "<p>No history found.</p>"; } ?>
      </div>
    </section>

    <section id="prescription" class="section hidden">
      <h1>Write Prescription</h1>
      <div class="form-box">
        <form action="../Controller/doctorActions.php" method="POST">
            <input type="hidden" name="action" value="add_prescription">
            <label>Patient ID</label><input name="patient_id" type="number" required placeholder="Check Appointments for ID" />
            <label>Medicine</label>
            <select name="medicine_id" required>
                <?php $medicines->data_seek(0); while($med = $medicines->fetch_assoc()) { echo "<option value='".$med['MedicineID']."'>".$med['Name']." (".$med['Strength'].")</option>"; } ?>
            </select>
            <label>Dosage</label><input name="dosage" required placeholder="e.g., 1-0-1" />
            <label>Duration</label><input name="duration" required placeholder="e.g., 7 days" />
            <button type="submit" class="btn-primary" style="margin-top:15px;">Save Prescription</button>
        </form>
      </div>
    </section>

    <section id="fee" class="section hidden">
      <h1>Update Visit Fee</h1>
      <div class="form-box">
        <form action="../Controller/doctorActions.php" method="POST">
            <input type="hidden" name="action" value="update_fee">
            <label>Current Fee</label><input name="fee" type="number" value="<?php echo $profile['VisitFee']; ?>" required />
            <button type="submit" class="btn-primary">Update Fee</button>
        </form>
      </div>
    </section>

  </main>
</div>
<script src="../Asset/doctor_script.js"></script>
</body>
</html>