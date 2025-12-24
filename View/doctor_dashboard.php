<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}
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
      <button onclick="showSection('profile')">1. My Profile</button>
      <button onclick="showSection('availability')">2. Availability</button>
      <button onclick="showSection('appointments')">3. Appointments</button>
      <button onclick="showSection('history')">4. Patient History</button>
      <button onclick="showSection('prescription')">5. Write Prescription</button>
      <button onclick="showSection('fee')">6. Update Visit Fee</button>
    </nav>
    <button onclick="logout()" class="logout-btn">Log Out</button>
  </aside>

  <main class="main-content">
    <section id="profile" class="section">
      <h1>My Profile</h1>
      <div class="form-box">
        <label>Name</label><input id="docName" value="<?php echo $_SESSION['name']; ?>" />
        <label>Email</label><input id="docEmail" />
        <label>Phone</label><input id="docPhone" />
        <label>Specialization</label><input id="docSpec" />
        <label>Experience (Years)</label><input id="docExp" />
        <label>New Password</label><input id="docPassword" type="password" placeholder="Enter to change" />
        <button class="btn-primary" onclick="updateProfile()">Update Profile</button>
      </div>
    </section>

    <section id="availability" class="section hidden">
      <h1>Update Availability</h1>
      <div class="form-row">
        <input id="availDate" type="date" />
        <input id="availTime" type="time" />
        <button class="btn-success" onclick="addAvailability()">Add Slot</button>
      </div>
      <h3>Current Slots</h3>
      <div id="availabilityList" class="card-grid"></div>
    </section>

    <section id="appointments" class="section hidden">
      <h1>Appointment Requests</h1>
      <div id="appointmentList" class="card-grid"></div>
    </section>

    <section id="history" class="section hidden">
      <h1>Patient History</h1>
      <div id="historyList" class="card-grid"></div>
    </section>

    <section id="prescription" class="section hidden">
      <h1>Write Prescription</h1>
      <div class="form-box">
        <label>Patient ID</label><input id="presPatientId" />
        <label>Medicine</label><select id="medicineSelect"></select>
        <label>Dosage (e.g. 1-0-1)</label><input id="dosePerDay" />
        <label>Duration (Days)</label><input id="duration" />
        <div style="margin-top: 15px;">
          <button class="btn-primary" onclick="writePrescription()">Save Prescription</button>
          <button class="btn-info" onclick="requestNewMedicine()">Request New Medicine</button>
        </div>
      </div>
    </section>

    <section id="fee" class="section hidden">
      <h1>Update Visit Fee</h1>
      <div class="form-box">
        <label>Current Fee</label><input id="visitFee" />
        <button class="btn-primary" onclick="updateFee()">Update Fee</button>
      </div>
    </section>
  </main>
</div>
<script src="../Asset/doctor_script.js"></script>
</body>
</html>