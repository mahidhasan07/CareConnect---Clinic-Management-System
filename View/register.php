<!DOCTYPE html>
<html>
<head>
    <title>CMS - Register</title>
    <link rel="stylesheet" href="../Asset/style.css">
</head>
<body>
    <div class="form-box">
        <h2>Patient Registration</h2>
        <form action="../Controller/registerCheck.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            
            <input type="email" name="email" placeholder="Email" required>
            
            <input type="password" name="password" placeholder="Password" required>
            
            <input type="text" name="phone" placeholder="Phone Number" required>

            <input type="number" name="age" placeholder="Age" required>
            
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="address" placeholder="Address" required>
            
            <input type="hidden" name="role" value="patient">

            <input type="submit" name="submit" value="Register Now" class="btn">
        </form>
        <br>
        <p>Already registered? <a href="login.php" style="color:#007bff; margin:0;">Login</a></p>
    </div>
</body>
</html>