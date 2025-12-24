<?php
session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit();
}
$role = $_SESSION['role'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - <?php echo ucfirst($role); ?></title>
    <link rel="stylesheet" href="../Asset/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>CMS | <?php echo ucfirst($role); ?> Panel</h1>
            <ul>
                <li>Hello, <?php echo $name; ?></li>
                <li><a href="../Controller/logoutCheck.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <?php if ($role == 'admin') { ?>
            <div class="dashboard-card">
                <h3>Admin Dashboard</h3>
                <p>Welcome Admin. You have full control.</p>
                <ul>
                    [cite_start]<li>Manage Doctor Records [cite: 15]</li>
                    [cite_start]<li>View All Appointments [cite: 15]</li>
                    [cite_start]<li>Manage Medicine List [cite: 15]</li>
                    [cite_start]<li>System Backup [cite: 15]</li>
                </ul>
            </div>
        <?php } ?>

        <?php if ($role == 'doctor') { ?>
            <div class="dashboard-card">
                <h3>Doctor Dashboard</h3>
                <p>Welcome Doctor.</p>
                <ul>
                    [cite_start]<li>Manage Availability [cite: 15]</li>
                    [cite_start]<li>Approve/Reject Appointments [cite: 16]</li>
                    [cite_start]<li>View Patient History [cite: 16]</li>
                    [cite_start]<li>Issue Prescriptions [cite: 16]</li>
                </ul>
            </div>
        <?php } ?>

        <?php if ($role == 'patient') { ?>
            <div class="dashboard-card">
                <h3>Patient Dashboard</h3>
                <p>Welcome Patient.</p>
                <ul>
                    [cite_start]<li>Search Doctor by Specialization [cite: 16]</li>
                    [cite_start]<li>Book/Cancel Appointment [cite: 16]</li>
                    [cite_start]<li>View Prescriptions [cite: 16]</li>
                    [cite_start]<li>Update Medical History [cite: 16]</li>
                </ul>
            </div>
        <?php } ?>

    </div>
</body>
</html>