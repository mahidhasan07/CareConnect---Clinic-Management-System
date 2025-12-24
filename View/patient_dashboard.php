<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <h1>Welcome Back, <?php echo $_SESSION['name']; ?>!</h1>
      <div class="card-grid" style="flex-direction: row; flex-wrap: wrap;">
        <div class="card" style="width: 200px; text-align: center;">
            <h3>Upcoming Appts</h3>
            <p id="stat-appts" style="font-size: 2rem; font-weight: bold; color: #2c3e50;">0</p>
        </div>
        <div class="card" style="width: 200px; text-align: center;">
            <h3>Prescriptions</h3>
            <p id="stat-presc" style="font-size: 2rem; font-weight: bold; color: #2c3e50;">0</p>
        </div>
      </div>
    </section>

    <section id="profile" class="section">
      <h1>My Profile</h1>
      <div class="form-box">
        <label>Full Name</label><input id="patName" value="<?php echo $_SESSION['name']; ?>" />
        <label>Email</label><input id="patEmail" placeholder="Email" />
        <label>Phone Number</label><input id="patPhone" placeholder="Phone" />
        <label>Medical History</label><textarea id="patHistory" rows="3" placeholder="e.g. Diabetes"></textarea>
        <label>New Password</label><input id="patPassword" type="password" />
        <button class="btn-primary" onclick="updateProfile()">Update Profile</button>
      </div>
    </section>

    <section id="search" class="section">
      <h1>Search & Book Doctor</h1>
      <div class="form-box" style="max-width: 100%;">
        <label>Filter by Specialization:</label>
        <div class="form-row">
          <select id="specSelect" onchange="filterDoctors()">
            <option value="All">All Specializations</option>
            <option value="Cardiology">Cardiology</option>
            <option value="Neurology">Neurology</option>
            <option value="General">General Physician</option>
            <option value="Dermatology">Dermatology</option>
          </select>
        </div>
      </div>
      <h3>Available Doctors</h3>
      <div id="doctorList" class="card-grid"></div>
    </section>

    <section id="appointments" class="section">
      <h1>My Appointments</h1>
      <div id="appointmentList" class="card-grid"></div>
    </section>

    <section id="prescriptions" class="section">
      <h1>My Prescriptions</h1>
      <div id="prescriptionList" class="card-grid"></div>
    </section>
  </main>
</div>
<script src="../Asset/patient_script.js"></script>
</body>
</html>