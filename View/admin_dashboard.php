<?php
require_once '../Controller/session_auth.php'; // Handles Session Start & Timeout
require_once '../Model/AdminModel.php';

// Role Security Check
if ($_SESSION['role'] !== 'admin') { header("Location: login.php"); exit(); }

$doctors = getAllDoctors();
$patients = getAllPatients();
$medicines = getAllMedicines();
$appointments = getAllAppointments();
$counts = getDashboardCounts();
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
        </ul>
        
        <div class="logout-container">
            <li onclick="logout()" class="logout-btn">Log Out</li>
        </div>
    </div>
    <div class="main-content">
        <div id="dashboard" class="section active">
            <h1>Dashboard Overview</h1>
            <div class="cards-container">
                <div class="card"><h3>Doctors</h3><p><?php echo $counts['doctors']; ?></p></div>
                <div class="card"><h3>Patients</h3><p><?php echo $counts['patients']; ?></p></div>
                <div class="card"><h3>Medicines</h3><p><?php echo $counts['medicines']; ?></p></div>
                <div class="card"><h3>Appointments</h3><p><?php echo $counts['appointments']; ?></p></div>
            </div>
        </div>
        <div id="profile" class="section">
            <h1>My Profile</h1>
            <div class="simple-form-box">
                <form action="../Controller/updateProfile.php" method="POST">
                    <label>Full Name:</label><input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" required>
                    <label>Email (Read Only):</label><input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>
                    <button type="submit" class="btn-save">Update Profile</button>
                </form>
            </div>
        </div>
        <div id="doctors" class="section">
            <div class="header-row"><h1>Manage Doctors</h1><button class="btn-add" onclick="openModal('doctor-modal')">+ Add Doctor</button></div>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Spec</th><th>Phone</th><th>Fee</th><th>Action</th></tr></thead>
                <tbody>
                    <?php while($row = $doctors->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['FullName']; ?></td>
                        <td><?php echo $row['Specialization']; ?></td>
                        <td><?php echo $row['PhoneNumber']; ?></td>
                        <td><?php echo $row['VisitFee']; ?></td>
                        <td>
                            <button class="btn-save" onclick="openEditDoctorModal('<?php echo $row['DoctorID']; ?>', '<?php echo $row['FullName']; ?>', '<?php echo $row['Specialization']; ?>', '<?php echo $row['PhoneNumber']; ?>', '<?php echo $row['VisitFee']; ?>')">Edit</button>
                            <a href="../Controller/deleteDoctor.php?id=<?php echo $row['DoctorID']; ?>" class="btn-cancel" onclick="return confirm('Delete?');">Remove</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="patients" class="section">
            <h1>Manage Patients</h1>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Age</th><th>Gender</th><th>Phone</th></tr></thead>
                <tbody><?php while($row = $patients->fetch_assoc()) { ?><tr><td><?php echo $row['FullName']; ?></td><td><?php echo $row['Age']; ?></td><td><?php echo $row['Gender']; ?></td><td><?php echo $row['PhoneNumber']; ?></td></tr><?php } ?></tbody>
            </table>
        </div>
        <div id="appointments" class="section">
            <h1>All Appointments</h1>
            <table class="styled-table">
                <thead><tr><th>Patient</th><th>Doctor</th><th>Date/Time</th><th>Status</th></tr></thead>
                <tbody><?php while($row = $appointments->fetch_assoc()) { ?><tr><td><?php echo $row['PatientName']; ?></td><td><?php echo $row['DoctorName']; ?></td><td><?php echo $row['Date']." ".$row['Time']; ?></td><td><?php echo $row['Status']; ?></td></tr><?php } ?></tbody>
            </table>
        </div>
        <div id="medicines" class="section">
            <div class="header-row"><h1>Master Medicine List</h1><button class="btn-add" onclick="openModal('medicine-modal')">+ Add Medicine</button></div>
            <table class="styled-table">
                <thead><tr><th>Name</th><th>Type</th><th>Strength</th><th>Manufacturer</th><th>Action</th></tr></thead>
                <tbody>
                    <?php while($row = $medicines->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Type']; ?></td>
                        <td><?php echo $row['Strength']; ?></td>
                        <td><?php echo $row['ManufacturerName']; ?></td>
                        <td>
                            <button class="btn-save" onclick="openEditMedicineModal('<?php echo $row['MedicineID']; ?>', '<?php echo $row['Name']; ?>', '<?php echo $row['Type']; ?>', '<?php echo $row['Strength']; ?>', '<?php echo $row['ManufacturerName']; ?>')">Edit</button>
                            <a href="../Controller/deleteMedicine.php?id=<?php echo $row['MedicineID']; ?>" class="btn-cancel" onclick="return confirm('Delete?');">Remove</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div id="doctor-modal" class="modal">
        <div class="modal-content">
            <h3>Add New Doctor</h3>
            <form action="../Controller/addDoctorCheck.php" method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Login Email" required>
                <input type="text" name="spec" placeholder="Specialization" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <input type="number" name="fee" placeholder="Visit Fee" required>
                <input type="password" name="password" placeholder="Password" required>
                <div class="form-buttons"><button type="submit" name="add_doctor" class="btn-save">Save</button><button type="button" class="btn-cancel" onclick="closeModal('doctor-modal')">Cancel</button></div>
            </form>
        </div>
    </div>
    
    <div id="medicine-modal" class="modal">
        <div class="modal-content">
            <h3>Add New Medicine</h3>
            <form action="../Controller/addMedicineCheck.php" method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="type" placeholder="Type" required>
                <input type="text" name="strength" placeholder="Strength" required>
                <input type="text" name="maker" placeholder="Manufacturer" required>
                <div class="form-buttons"><button type="submit" name="add_medicine" class="btn-save">Save</button><button type="button" class="btn-cancel" onclick="closeModal('medicine-modal')">Cancel</button></div>
            </form>
        </div>
    </div>

    <div id="edit-doctor-modal" class="modal">
        <div class="modal-content">
            <h3>Edit Doctor Details</h3>
            <form action="../Controller/updateDoctorCheck.php" method="POST">
                <input type="hidden" id="edit_doc_id" name="id">
                <label>Name:</label>
                <input type="text" id="edit_doc_name" name="name" required>
                <label>Specialization:</label>
                <input type="text" id="edit_doc_spec" name="spec" required>
                <label>Phone:</label>
                <input type="text" id="edit_doc_phone" name="phone" required>
                <label>Visit Fee:</label>
                <input type="number" id="edit_doc_fee" name="fee" required>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">Update</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('edit-doctor-modal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-medicine-modal" class="modal">
        <div class="modal-content">
            <h3>Edit Medicine Details</h3>
            <form action="../Controller/updateMedicineCheck.php" method="POST">
                <input type="hidden" id="edit_med_id" name="id">
                <label>Name:</label>
                <input type="text" id="edit_med_name" name="name" required>
                <label>Type:</label>
                <input type="text" id="edit_med_type" name="type" required>
                <label>Strength:</label>
                <input type="text" id="edit_med_strength" name="strength" required>
                <label>Manufacturer:</label>
                <input type="text" id="edit_med_maker" name="maker" required>
                <div class="form-buttons">
                    <button type="submit" class="btn-save">Update</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('edit-medicine-modal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../Asset/admin_script.js"></script>
</body>
</html>