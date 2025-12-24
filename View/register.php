<!DOCTYPE html>
<html>
<head>
    <title>CMS - Register</title>
    <link rel="stylesheet" href="../Asset/style.css">
    <script src="../Asset/script.js"></script>
</head>
<body>
    <div class="form-box">
        <h2>Register</h2>
        <form action="../Controller/registerCheck.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" placeholder="Phone Number">
            
            <label>Register As:</label>
            <select name="role" id="role" onchange="toggleFields()">
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="admin">Admin</option>
            </select>

            <div id="specialization-group" style="display:none;">
                <input type="text" name="specialization" placeholder="Specialization (e.g., Dental)">
            </div>

            <input type="submit" name="submit" value="Register Now" class="btn">
        </form>
        <br>
        <p>Already registered? <a href="login.php" style="color:#007bff; margin:0;">Login</a></p>
    </div>
</body>
</html>