<?php
$servername = "localhost";
$username = "root";       // Default XAMPP username
$password = "";           // Default XAMPP password (usually empty)
$dbname = "Clinic_Management_System 3"; // Must match your SQL file name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>