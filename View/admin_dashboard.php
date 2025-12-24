<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMS Admin Dashboard</title>
    <link rel="stylesheet" href="../Asset/admin_style.css">
</head>
<body>

    <div class="sidebar">
        <h2>CMS Admin</h2>
        <ul>
            <li onclick="showSection('dashboard')">1. Dashboard</li>
            <li onclick="showSection('profile')">2. My Profile</li>
            <li onclick="showSection('doctors')">3. Manage Doctors</li>
            <li onclick="showSection('patients')">5. Manage Patients</li>
            <li onclick="showSection('appointments')">4. Appointments</li>
            <li onclick="showSection('medicines')">6. Medicine List</li>
            <li onclick="showSection('backups')">7. Backups</li>
            <li onclick="logout()" class="logout-btn">Log Out</li>
        </ul>
    </div>

    <div class="main-content">
        <div id="dashboard" class="section active">
            <h1>Dashboard Overview</h1>
            <div class="cards-container">
                <div class="card"><h3>Doctors</h3><p id="total-doctors">0</p></div>
                <div class="card"><h3>Patients</h3><p id="total-patients">0</p></div>
                <div class="card"><h3>Medicines</h3><p id="total-medicines">0</p></div>
                <div class="card"><h3>Appointments</h3><p id="total-appointments">0</p></div>
            </div>
        </div>

        <div id="profile" class="section">
            <h1>My Profile</h1>
            <div class="simple-form-box">
                <form onsubmit="updateProfile(event)">
                    <label>Full Name:</label><input type="text" value="<?php echo $_SESSION['name']; ?>">
                    <label>Email:</label><input type="email" value="admin@clinic.com">
                    <label>New Password:</label><input type="password" placeholder="Enter new password">
                    <button type="submit" class="btn-save">Update Profile</button>
                </form>
            </div>
        </div>

        <div id="doctors" class="section">
            <div class="header-row">
                <h1>Manage Doctors</h1>
                <button class="btn-add" onclick="openModal('doctor-modal')">+ Add Doctor</button>
            </div>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Specialization</th><th>Phone</th><th>Fee</th><th>Action</th></tr></thead>
                <tbody id="doctor-list"></tbody>
            </table>
        </div>

        <div id="patients" class="section">
            <h1>Manage Patients</h1>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Age</th><th>Gender</th><th>Phone</th></tr></thead>
                <tbody id="patient-list"></tbody>
            </table>
        </div>

        <div id="appointments" class="section">
            <h1>All Appointments</h1>
            <table class="styled-table">
                <thead><tr><th>Patient</th><th>Doctor</th><th>Date/Time</th><th>Status</th></tr></thead>
                <tbody id="appointment-list"></tbody>
            </table>
        </div>

        <div id="medicines" class="section">
            <div class="header-row">
                <h1>Master Medicine List</h1>
                <button class="btn-add" onclick="openModal('medicine-modal')">+ Add Medicine</button>
            </div>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Type</th><th>Strength</th><th>Manufacturer</th><th>Action</th></tr></thead>
                <tbody id="medicine-list"></tbody>
            </table>
        </div>
        
        <div id="backups" class="section">
            <div class="header-row">
                <h1>System Backups</h1>
                <button class="btn-add" onclick="createBackup()">Create New Backup</button>
            </div>
            <table class="styled-table">
                <thead><tr><th>File Name</th><th>Date</th><th>Action</th></tr></thead>
                <tbody id="backup-list"></tbody>
            </table>
        </div>
    </div>

    <div id="doctor-modal" class="modal">
        <div class="modal-content">
            <h3>Add New Doctor</h3>
            <form onsubmit="saveDoctor(event)">
                <input type="text" id="docName" placeholder="Full Name" required>
                <input type="text" id="docSpec" placeholder="Specialization" required>
                <input type="text" id="docPhone" placeholder="Phone Number" required>
                <input type="number" id="docFee" placeholder="Visit Fee" required>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('doctor-modal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="medicine-modal" class="modal">
        <div class="modal-content">
            <h3>Add New Medicine</h3>
            <form onsubmit="saveMedicine(event)">
                <input type="text" id="medName" placeholder="Medicine Name" required>
                <input type="text" id="medType" placeholder="Type (Tablet, Syrup)" required>
                <input type="text" id="medStrength" placeholder="Strength (e.g., 500mg)" required>
                <input type="text" id="medMaker" placeholder="Manufacturer" required>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('medicine-modal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../Asset/admin_script.js"></script>
</body>
</html>